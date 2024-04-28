<?php

declare(strict_types=1);

namespace toby7002\Phenol;

use GlobalLogger;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Internet;

class UpdateNotifier
{
    public static function init(PluginBase $plugin): void
    {
        $pluginName = $plugin->getDescription()->getName();
        $pluginVersion = $plugin->getDescription()->getVersion();

        $plugin->getServer()->getAsyncPool()->submitTask(new class ($pluginName, $pluginVersion) extends AsyncTask {
            private static int $BAD_RESPONSE = 0;
            private static int $OUTDATED = 1;
            private static int $UP2DATE = 2;

            public function __construct(private readonly string $pluginName, private readonly string $pluginVersion) {}

            public function onRun(): void
            {
                $res = Internet::getURL("https://poggit.pmmp.io/releases.min.json", 10, [], $err);

                if ($err) {
                    $this->setResult(self::$BAD_RESPONSE);
                    return;
                }

                if ($res->getCode() !== 200) {
                    $this->setResult(self::$BAD_RESPONSE);
                    return;
                }

                $json = json_decode($res->getBody(), true);

                if ($json === null) {
                    $this->setResult(self::$BAD_RESPONSE);
                    return;
                }

                $updateFound = false;
                foreach ($json as $release) {
                    if (isset($release["name"], $release["version"]) && $release["name"] === $this->pluginName && version_compare($release["version"], $this->pluginVersion, ">")) {
                        $this->setResult(self::$OUTDATED);
                        $updateFound = true;
                        break;
                    }
                }

                if (!$updateFound) {
                    $this->setResult(self::$UP2DATE);
                }
            }

            public function onCompletion(): void
            {
                $result = $this->getResult();
                switch ($result) {
                    case self::$BAD_RESPONSE:
                        GlobalLogger::get()->error("Cannot send request to Poggit API");
                        break;
                    case self::$OUTDATED:
                        GlobalLogger::get()->error($this->pluginName . " v" . $this->pluginVersion . " is outdated!");
                        break;
                    case self::$UP2DATE:
                        break;
                }
            }
        });
    }
}

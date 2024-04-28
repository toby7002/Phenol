<?php

namespace toby7002\Phenol;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\scheduler\Task;

class Phenol
{
    public function __construct(private readonly PluginBase $plugin) {}

    /**
     * Most Phenol's function need to be run by this function.
     *
     * @param Task|AsyncTask $task
     * @return void
     */
    public function runTask(Task|AsyncTask $task): void
    {
        if ($task instanceof Task) {
            $this->plugin->getScheduler()->scheduleTask($task);
        } else {
            $this->plugin->getServer()->getAsyncPool()->submitTask($task);
        }
    }

    /**
     * @return void
     */
    public function checkForUpdates(): void
    {
        UpdateNotifier::init($this->plugin);
    }

    public function getLogger(): Logger
    {
        return new Logger($this->plugin->getLogger());
    }
}

<?php

namespace toby7002\Phenol;

use Phar;
use pocketmine\scheduler\AsyncTask;
use Symfony\Component\Filesystem\Filesystem as Fs;

class PharHelper
{
    public static function extract(string $path, string $to): AsyncTask
    {
        return new class ($path, $to) extends AsyncTask {
            public function __construct(private readonly string $path, private readonly string $to) {}

            public function onRun(): void
            {
                $phar = new Phar($this->path);
                $phar->extractTo($this->to);
            }
        };
    }

    public static function make(string $path, string $content): AsyncTask
    {
        return Filesystem::dumpFile($path, $content);
    }
}

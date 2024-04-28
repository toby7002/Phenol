<?php

namespace toby7002\Phenol;

use pocketmine\scheduler\AsyncTask;
use Symfony\Component\Filesystem\Filesystem as Fs;

class Filesystem
{
    /**
     * Deletes files, directories and symlinks:
     *
     * @param string $path
     * @return AsyncTask
     */
    public static function remove(string $path): AsyncTask
    {
        return new class($path) extends AsyncTask {
            private Fs $fs;
            public function __construct(private readonly string $path)
            {
                $this->fs = new Fs();
            }

            public function onRun(): void
            {
                $this->fs->remove($this->path);
            }
        };
    }

    /**
     * Changes the name of a single file or directory
     * If the target already exists, a third boolean argument is available to overwrite.
     *
     * @param string $old
     * @param string $new
     * @param bool $force
     * @return AsyncTask
     */
    public static function rename(string $old, string $new, bool $force = false): AsyncTask
    {
        return new class($old, $new, $force) extends AsyncTask {
            private Fs $fs;
            public function __construct(private readonly string $old,private readonly string $new,private readonly bool $force = false)
            {
                $this->fs = new Fs();
            }

            public function onRun(): void
            {
                $this->fs->rename($this->old, $this->new, $this->force);
            }
        };
    }

    /**
     * Saves the given contents into a file
     *
     * @param string $path
     * @param string $content
     * @return AsyncTask
     */
    public static function dumpFile(string $path, string $content): AsyncTask
    {
        return new class($path, $content) extends AsyncTask {
            private Fs $fs;
            public function __construct(private readonly string $path,private readonly string $content)
            {
                $this->fs = new Fs();
            }

            public function onRun(): void
            {
                $this->fs->dumpFile($this->path, $this->content);
            }
        };
    }
}
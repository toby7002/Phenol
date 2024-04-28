<?php

declare(strict_types=1);

namespace toby7002\Phenol\trait;

trait PSingletonPattern
{
    /** @var self|null */
    private static $instance = null;

    private static function make(): self
    {
        return new self();
    }

    public static function getInstance(): self
    {
        if(self::$instance === null) {
            self::$instance = self::make();
        }
        return self::$instance;
    }

    public static function setInstance(self $instance): void
    {
        self::$instance = $instance;
    }

    public static function reset(): void
    {
        self::$instance = null;
    }
}

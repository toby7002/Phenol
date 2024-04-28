<?php

declare(strict_types=1);

namespace toby7002\Phenol\trait;

trait PSingletonPattern
{
    /** @var self|null */
    private static $pInstance = null;

    private static function make(): self
    {
        return new self();
    }

    public static function getPInstance(): self
    {
        if(self::$pInstance === null) {
            self::$pInstance = self::make();
        }
        return self::$pInstance;
    }

    public static function setPInstance(self $instance): void
    {
        self::$pInstance = $instance;
    }

    public static function pReset(): void
    {
        self::$pInstance = null;
    }
}

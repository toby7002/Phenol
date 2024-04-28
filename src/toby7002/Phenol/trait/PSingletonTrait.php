<?php

declare(strict_types=1);

namespace toby7002\Phenol\trait;

trait PSingletonTrait
{
    /** @var self|null */
    private static $phenol = null;

    private static function make(): self
    {
        return new self();
    }

    public static function getPhenol(): self
    {
        if(self::$phenol === null) {
            self::$phenol = self::make();
        }
        return self::$phenol;
    }

    public static function setPhenol(self $instance): void
    {
        self::$phenol = $instance;
    }
}

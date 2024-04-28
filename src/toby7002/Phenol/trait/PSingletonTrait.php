<?php

declare(strict_types=1);

namespace toby7002\Phenol\trait;

use toby7002\Phenol\Phenol;

trait PSingletonTrait
{
    /** @var Phenol|null */
    private static ?Phenol $phenol = null;

    public static function getPhenol(): Phenol
    {
        return self::$phenol;
    }

    public static function setPhenol(Phenol $instance): void
    {
        self::$phenol = $instance;
    }
}

<?php

namespace App\Traits;

trait Cacheable
{
    public static function bootCacheable(): void
    {
        static::eventCreated();
        static::eventUpdated();
        static::eventDeleted();
    }

    public static function eventCreated(): void
    {
        static::created(function () {
            static::flush();
        });
    }

    public static function eventUpdated(): void
    {
        static::updated(function () {
            static::flush();
        });
    }

    public static function eventDeleted(): void
    {
        static::deleted(function () {
            static::flush();
        });
    }

    protected static function flush()
    {
        cache()->tags(static::$cacheTags)->flush();
    }
}

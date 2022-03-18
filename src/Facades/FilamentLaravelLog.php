<?php

namespace Saade\FilamentLaravelLog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Saade\FilamentLaravelLog\FilamentLaravelLog
 */
class FilamentLaravelLog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-laravel-log';
    }
}

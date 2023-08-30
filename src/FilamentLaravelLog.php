<?php

namespace Saade\FilamentLaravelLog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class FilamentLaravelLog implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-laravel-log';
    }


    public function boot(Panel $panel): void
    {
        //est
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            ViewLog::class,
        ]);
    }

}

<?php

namespace Saade\FilamentLaravelLog\Pages\Concerns;

use Closure;
use Saade\FilamentLaravelLog\Pages\ViewLog;

trait HasSecurity
{
    public static ?Closure $can = null;

    public function mount()
    {
        abort_unless(static::canAccessPage(), 403);
    }

    public static function can(Closure $callback): void
    {
        static::$can = $callback;
    }

    public static function canAccessPage(): bool
    {
        if (config('filament-laravel-log.authorization')) {
            return static::$can && (static::$can)(auth()->user());
        }

        return true;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccessPage();
    }
}

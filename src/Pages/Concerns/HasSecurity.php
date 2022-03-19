<?php

namespace Saade\FilamentLaravelLog\Pages\Concerns;

use Closure;

trait HasSecurity
{
    protected static ?Closure $can = null;

    public function mount()
    {
        parent::mount();
        abort_unless(static::canAccessPage(), 403);
    }

    public static function can(Closure $callback): void
    {
        static::$can = $callback;
    }

    protected static function canAccessPage(): bool
    {
        if (config('filament-laravel-log.authorization')) {
            return static::$can && (static::$can)(auth()->user());
        }

        return true;
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return static::canAccessPage();
    }
}

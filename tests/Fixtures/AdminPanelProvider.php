<?php

namespace Saade\FilamentLaravelLog\Tests\Fixtures;

use Closure;
use Filament\Panel;
use Filament\PanelProvider;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @var array<string>
     */
    public static array $logDirs = [];

    /**
     * @var array<string>
     */
    public static array $excludedFilesPatterns = [];

    public static bool | Closure $authorize = true;

    /**
     * @var (Closure(FilamentLaravelLogPlugin): FilamentLaravelLogPlugin) | null
     */
    public static ?Closure $configurePluginUsing = null;

    public static function reset(): void
    {
        static::$logDirs = [];
        static::$excludedFilesPatterns = [];
        static::$authorize = true;
        static::$configurePluginUsing = null;
    }

    public function panel(Panel $panel): Panel
    {
        $plugin = FilamentLaravelLogPlugin::make()
            ->logDirs(fn (): array => static::$logDirs)
            ->excludedFilesPatterns(fn (): array => static::$excludedFilesPatterns)
            ->authorize(fn (): mixed => value(static::$authorize));

        if (static::$configurePluginUsing) {
            $plugin = (static::$configurePluginUsing)($plugin);
        }

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin($plugin);
    }
}

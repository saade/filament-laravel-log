<?php

namespace Saade\FilamentLaravelLog\Tests\Fixtures;

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

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin(
                FilamentLaravelLogPlugin::make()
                    ->logDirs(fn (): array => static::$logDirs)
                    ->excludedFilesPatterns(fn (): array => static::$excludedFilesPatterns),
            );
    }
}

<?php

namespace Saade\FilamentLaravelLog\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class SecondPanelProvider extends PanelProvider
{
    public static bool $hasPlugin = false;

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default(! AdminPanelProvider::$isDefault)
            ->id('second')
            ->path('second')
            ->plugins(static::$hasPlugin ? [FilamentLaravelLogPlugin::make()->slug('second-logs')] : []);
    }
}

<?php

namespace Saade\FilamentLaravelLog;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Saade\FilamentLaravelLog\Commands\UpgradeFilamentLaravelLogCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLaravelLogServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-laravel-log';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::$name)
            ->hasViews(self::$name)
            ->hasConfigFile(self::$name)
            ->hasTranslations()
            ->hasCommands([
                UpgradeFilamentLaravelLogCommand::class,
            ]);
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make(self::$name . '-ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.14/ace.js'),
            Css::make(self::$name . '-styles', __DIR__ . '/../dist/css/filament-laravel-log.css'),
        ], 'saade/' . self::$name);
    }
}

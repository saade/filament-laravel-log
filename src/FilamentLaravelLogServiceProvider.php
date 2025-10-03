<?php

namespace Saade\FilamentLaravelLog;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLaravelLogServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-laravel-log';

    public static string $viewNamespace = 'filament-laravel-log';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('saade/filament-laravel-log');
            });

        if (file_exists($package->basePath('/../config/' . static::$name . '.php'))) {
            $package->hasConfigFile(static::$name);
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );
    }

    protected function getAssetPackageName(): ?string
    {
        return 'saade/filament-laravel-log';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('filament-laravel-log', __DIR__ . '/../resources/dist/filament-laravel-log.js'),
            Css::make('filament-laravel-log-styles', __DIR__ . '/../resources/dist/filament-laravel-log.css'),
        ];
    }
}

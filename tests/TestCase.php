<?php

namespace Saade\FilamentLaravelLog\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Facades\Filament;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\User;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Saade\FilamentLaravelLog\FilamentLaravelLogServiceProvider;
use Saade\FilamentLaravelLog\Tests\Fixtures\AdminPanelProvider;

class TestCase extends Orchestra
{
    protected string $root;

    protected function setUp(): void
    {
        $this->root = realpath(sys_get_temp_dir()) . '/filament-laravel-log-' . bin2hex(random_bytes(6));

        mkdir("{$this->root}/storage/logs", recursive: true);

        AdminPanelProvider::$logDirs = ["{$this->root}/storage/logs"];
        AdminPanelProvider::$excludedFilesPatterns = [];

        parent::setUp();

        $this->actingAs((new User)->forceFill(['id' => 1, 'name' => 'Admin', 'email' => 'admin@example.com']));

        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        (new Filesystem)->deleteDirectory($this->root);
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            ActionsServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentServiceProvider::class,
            FilamentLaravelLogServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('a', 32)));
    }

    protected function log(string $path, string $content = "[2026-10-07 10:00:00] local.ERROR: boom\n"): string
    {
        $path = "{$this->root}/{$path}";

        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), recursive: true);
        }

        file_put_contents($path, $content);

        return $path;
    }
}

<?php

use Filament\Facades\Filament;
use Livewire\Livewire;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use Saade\FilamentLaravelLog\Pages\ViewLog;
use Saade\FilamentLaravelLog\Tests\Fixtures\AdminPanelProvider;
use Saade\FilamentLaravelLog\Tests\Fixtures\ReadOnlyViewLog;

it('adds the logs page to the panel', function () {
    expect(Filament::getPanel('admin')->getPages())->toContain(ViewLog::class);

    $this->get('/admin/logs')
        ->assertOk()
        ->assertSee('Logs')
        ->assertSee('filament-laravel-log-alpine');
});

it('renders its actions', function () {
    Livewire::test(ViewLog::class)
        ->assertSee(['Jump to Start', 'Refresh', 'Jump to End', 'Clear']);
});

it('is open to every user of the panel unless told otherwise', function () {
    expect(ViewLog::canAccess())->toBeTrue();
});

it('refuses users the authorize callback turns away', function () {
    AdminPanelProvider::$authorize = fn (): bool => auth()->user()->email === 'someone-else@example.com';

    expect(ViewLog::canAccess())->toBeFalse();

    $this->get('/admin/logs')->assertForbidden();

    Livewire::test(ViewLog::class)->assertForbidden();
});

it('lets in users the authorize callback accepts', function () {
    AdminPanelProvider::$authorize = fn (): bool => auth()->user()->email === 'admin@example.com';

    expect(ViewLog::canAccess())->toBeTrue();

    $this->get('/admin/logs')->assertOk();
});

it('only takes true for an answer from the authorize callback', function (mixed $answer) {
    AdminPanelProvider::$authorize = fn (): mixed => $answer;

    expect(ViewLog::canAccess())->toBeFalse();
})->with([1, 'yes', null, false]);

it('reads the log directory of the application by default', function () {
    $this->configurePlugin(fn (FilamentLaravelLogPlugin $plugin) => $plugin->logDirs([]));

    Filament::bootCurrentPanel();

    expect(FilamentLaravelLogPlugin::get()->getLogDirs())->toBe([storage_path('logs')]);
});

it('uses the page class it is given', function () {
    $this->configurePlugin(fn (FilamentLaravelLogPlugin $plugin) => $plugin->viewLog(ReadOnlyViewLog::class));

    expect(Filament::getPanel('admin')->getPages())
        ->toContain(ReadOnlyViewLog::class)
        ->not->toContain(ViewLog::class);
});

it('takes its navigation and title from the plugin', function () {
    $this->configurePlugin(fn (FilamentLaravelLogPlugin $plugin) => $plugin
        ->navigationGroup('System')
        ->navigationParentItem('Tools')
        ->navigationLabel('Application logs')
        ->navigationIcon('heroicon-o-bug-ant')
        ->activeNavigationIcon('heroicon-s-bug-ant')
        ->navigationBadge('3')
        ->navigationBadgeColor('danger')
        ->navigationBadgeTooltip('New errors')
        ->navigationSort(7)
        ->title('What happened')
        ->slug('system/logs'));

    expect(ViewLog::getNavigationGroup())->toBe('System')
        ->and(ViewLog::getNavigationParentItem())->toBe('Tools')
        ->and(ViewLog::getNavigationLabel())->toBe('Application logs')
        ->and(ViewLog::getNavigationIcon())->toBe('heroicon-o-bug-ant')
        ->and(ViewLog::getActiveNavigationIcon())->toBe('heroicon-s-bug-ant')
        ->and(ViewLog::getNavigationBadge())->toBe('3')
        ->and(ViewLog::getNavigationBadgeColor())->toBe('danger')
        ->and(ViewLog::getNavigationBadgeTooltip())->toBe('New errors')
        ->and(ViewLog::getNavigationSort())->toBe(7)
        ->and(ViewLog::getSlug())->toBe('system/logs');

    $this->get('/admin/system/logs')->assertOk()->assertSee('What happened');
});

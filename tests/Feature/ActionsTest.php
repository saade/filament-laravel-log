<?php

use Filament\Actions\Action;
use Livewire\Livewire;
use Saade\FilamentLaravelLog\Pages\ViewLog;
use Saade\FilamentLaravelLog\Tests\Fixtures\ReadOnlyViewLog;

it('disables the actions until a file is selected', function (string $action) {
    $log = $this->log('storage/logs/laravel.log');

    Livewire::test(ViewLog::class)
        ->assertActionDisabled($action)
        ->set('logFile', $log)
        ->assertActionEnabled($action);
})->with(['clear', 'refresh', 'jumpToStart', 'jumpToEnd']);

it('asks before clearing a file, then clears it', function () {
    $log = $this->log('storage/logs/laravel.log');

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertActionExists('clear', fn (Action $action): bool => $action->isConfirmationRequired())
        ->mountAction('clear')
        ->assertActionMounted('clear');

    expect(file_get_contents($log))->not->toBe('');

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->callAction('clear')
        ->assertDispatched('logContentUpdated', content: '');

    expect(file_get_contents($log))->toBe('');
});

it('sends the file again when it is refreshed', function () {
    $log = $this->log('storage/logs/laravel.log', "first\n");

    $page = Livewire::test(ViewLog::class)->set('logFile', $log);

    file_put_contents($log, "second\n", FILE_APPEND);

    $page
        ->callAction('refresh')
        ->assertDispatched('logContentUpdated', content: "first\nsecond\n");
});

it('hides the clear action on a page that is not clearable', function () {
    Livewire::test(ReadOnlyViewLog::class)
        ->assertActionHidden('clear')
        ->assertActionVisible('refresh')
        ->assertSeeHtml("mountAction('refresh')")
        ->assertDontSeeHtml("mountAction('clear')");

    Livewire::test(ViewLog::class)->assertSeeHtml("mountAction('clear')");
});

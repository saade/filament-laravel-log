<?php

use Filament\Notifications\Notification;
use Livewire\Livewire;
use Saade\FilamentLaravelLog\Pages\ViewLog;

it('shows a file that is not valid UTF-8', function () {
    $log = $this->log('storage/logs/laravel.log', "caf\xE9 closed\n");

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertDispatched('logContentUpdated', content: "caf? closed\n");
});

it('shows the contents of a compressed log file', function () {
    $log = $this->log('storage/logs/laravel-2026-10-01.log.gz', gzencode("rotated\n"));

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertDispatched('logContentUpdated', content: "rotated\n");
});

it('shows a file that is named like a compressed one but is not', function () {
    $log = $this->log('storage/logs/odd.gz', "plain text\n");

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertDispatched('logContentUpdated', content: "plain text\n");
});

it('says so when a file cannot be read', function () {
    $log = $this->log('storage/logs/laravel.log');

    chmod($log, 0000);

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertDispatched('logContentUpdated', content: '')
        ->assertNotified(Notification::make()->danger()->title('The file could not be read.'));

    chmod($log, 0644);
})->skip(fn (): bool => function_exists('posix_geteuid') && (posix_geteuid() === 0), 'Root can read any file.');

it('says so when a file cannot be cleared', function () {
    $log = $this->log('storage/logs/laravel.log', "keep me\n");

    chmod($log, 0444);

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->call('clear')
        ->assertNotified(Notification::make()->danger()->title('The file could not be cleared.'));

    expect(file_get_contents($log))->toBe("keep me\n");
})->skip(fn (): bool => function_exists('posix_geteuid') && (posix_geteuid() === 0), 'Root can write to any file.');

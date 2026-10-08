<?php

use Livewire\Livewire;
use Saade\FilamentLaravelLog\Pages\ViewLog;
use Saade\FilamentLaravelLog\Tests\Fixtures\AdminPanelProvider;
use Saade\FilamentLaravelLog\Tests\Fixtures\ReadOnlyViewLog;

const SECRET = "APP_KEY=secret\n";

it('reads a file from the log directory', function () {
    $log = $this->log('storage/logs/laravel.log', "first line\n");

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertSet('logFile', $log)
        ->assertDispatched('logContentUpdated', content: "first line\n");
});

it('reads a file from a folder inside the log directory', function () {
    $log = $this->log('storage/logs/workers/queue.log', "queued\n");

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->assertDispatched('logContentUpdated', content: "queued\n");
});

it('clears a file from the log directory', function () {
    $log = $this->log('storage/logs/laravel.log');

    Livewire::test(ViewLog::class)
        ->set('logFile', $log)
        ->call('clear')
        ->assertDispatched('logContentUpdated', content: '');

    expect(file_get_contents($log))->toBe('');
});

it('does not read a file outside the log directory', function (string $path) {
    $this->log('.env', SECRET);
    $this->log('storage/logs/laravel.log');
    $this->log('storage/logs-backup/old.log', SECRET);

    Livewire::test(ViewLog::class)
        ->set('logFile', "{$this->root}/{$path}")
        ->assertSet('logFile', null)
        ->assertDispatched('logContentUpdated', content: '')
        ->call('refresh')
        ->assertDispatched('logContentUpdated', content: '');
})->with([
    'a parent directory' => 'storage/logs/../../.env',
    'an absolute path' => '.env',
    'a directory whose name starts like the log directory' => 'storage/logs-backup/old.log',
    'a path that only mentions the log directory' => 'storage/logs/../logs-backup/old.log',
]);

it('does not clear a file outside the log directory', function (string $path) {
    $secret = $this->log('.env', SECRET);
    $this->log('storage/logs/laravel.log');
    $backup = $this->log('storage/logs-backup/old.log', SECRET);

    Livewire::test(ViewLog::class)
        ->set('logFile', "{$this->root}/{$path}")
        ->call('clear');

    expect(file_get_contents($secret))->toBe(SECRET)
        ->and(file_get_contents($backup))->toBe(SECRET);
})->with([
    'a parent directory' => 'storage/logs/../../.env',
    'an absolute path' => '.env',
    'a directory whose name starts like the log directory' => 'storage/logs-backup/old.log',
]);

it('does not read or clear a file that is excluded from the list', function () {
    AdminPanelProvider::$excludedFilesPatterns = ['*.secret.log'];

    $excluded = $this->log('storage/logs/payments.secret.log', SECRET);

    Livewire::test(ViewLog::class)
        ->set('logFile', $excluded)
        ->assertSet('logFile', null)
        ->assertDispatched('logContentUpdated', content: '')
        ->call('clear');

    expect(file_get_contents($excluded))->toBe(SECRET);
});

it('does not read a hidden file in the log directory', function () {
    $hidden = $this->log('storage/logs/.gitignore', SECRET);

    Livewire::test(ViewLog::class)
        ->set('logFile', $hidden)
        ->assertDispatched('logContentUpdated', content: '');
});

it('ignores a file that does not exist', function () {
    Livewire::test(ViewLog::class)
        ->set('logFile', "{$this->root}/storage/logs/missing.log")
        ->assertSet('logFile', null)
        ->assertDispatched('logContentUpdated', content: '');
});

it('reads the logs of a log directory that is reached through a link', function () {
    mkdir("{$this->root}/shared/logs", recursive: true);
    symlink("{$this->root}/shared/logs", "{$this->root}/current-logs");

    AdminPanelProvider::$logDirs = ["{$this->root}/current-logs"];

    $this->log('shared/logs/laravel.log', "deployed\n");

    Livewire::test(ViewLog::class)
        ->set('logFile', "{$this->root}/current-logs/laravel.log")
        ->assertDispatched('logContentUpdated', content: "deployed\n")
        ->set('logFile', "{$this->root}/shared/logs/laravel.log")
        ->assertDispatched('logContentUpdated', content: "deployed\n");
});

it('does not clear a file when the page is not clearable', function () {
    $log = $this->log('storage/logs/laravel.log', "keep me\n");

    Livewire::test(ReadOnlyViewLog::class)
        ->set('logFile', $log)
        ->call('clear');

    expect(file_get_contents($log))->toBe("keep me\n");
});

<?php

use Livewire\Livewire;
use Saade\FilamentLaravelLog\Tests\Fixtures\AdminPanelProvider;
use Saade\FilamentLaravelLog\Tests\Fixtures\InspectableViewLog;

function listedFiles(): array
{
    return Livewire::test(InspectableViewLog::class)->instance()->listedFiles();
}

it('lists the files of the log directory and of the folders inside it', function () {
    $laravel = $this->log('storage/logs/laravel.log');
    $worker = $this->log('storage/logs/workers/queue.log');

    expect(listedFiles())->toBe([$laravel, $worker]);
});

it('lists the files of every log directory', function () {
    $laravel = $this->log('storage/logs/laravel.log');
    $supervisor = $this->log('supervisor/worker.log');

    AdminPanelProvider::$logDirs[] = "{$this->root}/supervisor";

    expect(listedFiles())->toBe([$laravel, $supervisor]);
});

it('leaves out hidden files and the files that match an excluded pattern', function () {
    $laravel = $this->log('storage/logs/laravel.log');
    $this->log('storage/logs/.gitignore');
    $this->log('storage/logs/laravel-2023-01-01.log');

    AdminPanelProvider::$excludedFilesPatterns = ['*2023*'];

    expect(listedFiles())->toBe([$laravel]);
});

it('lists nothing when the log directory is empty', function () {
    expect(listedFiles())->toBe([]);
});

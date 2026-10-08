<?php

use Livewire\Livewire;
use Saade\FilamentLaravelLog\Tests\Fixtures\AdminPanelProvider;
use Saade\FilamentLaravelLog\Tests\Fixtures\InspectableViewLog;

function listedFiles(): array
{
    return Livewire::test(InspectableViewLog::class)->instance()->listedFiles();
}

it('lists the files of the log directory and of the folders inside it, by their path from it', function () {
    $laravel = $this->log('storage/logs/laravel.log');
    $worker = $this->log('storage/logs/workers/queue.log');

    expect(listedFiles())->toEqualCanonicalizing([
        $laravel => 'laravel.log',
        $worker => 'workers' . DIRECTORY_SEPARATOR . 'queue.log',
    ]);
});

it('lists the newest file first', function () {
    $old = $this->log('storage/logs/laravel-2026-10-05.log');
    $newest = $this->log('storage/logs/laravel-2026-10-07.log');
    $newer = $this->log('storage/logs/laravel-2026-10-06.log');

    touch($old, strtotime('2026-10-05 12:00'));
    touch($newer, strtotime('2026-10-06 12:00'));
    touch($newest, strtotime('2026-10-07 12:00'));

    expect(array_keys(listedFiles()))->toBe([$newest, $newer, $old]);
});

it('names the directory of a file when there are several log directories', function () {
    $laravel = $this->log('storage/logs/laravel.log');
    $supervisor = $this->log('supervisor/worker.log');

    AdminPanelProvider::$logDirs[] = "{$this->root}/supervisor";

    expect(listedFiles())->toEqualCanonicalizing([
        $laravel => 'logs' . DIRECTORY_SEPARATOR . 'laravel.log',
        $supervisor => 'supervisor' . DIRECTORY_SEPARATOR . 'worker.log',
    ]);
});

it('shows the whole path when two log directories have the same name', function () {
    $first = $this->log('storage/logs/laravel.log');
    $second = $this->log('other/logs/laravel.log');

    AdminPanelProvider::$logDirs[] = "{$this->root}/other/logs";

    expect(listedFiles())->toEqualCanonicalizing([$first => $first, $second => $second]);
});

it('leaves out hidden files and the files that match an excluded pattern', function () {
    $laravel = $this->log('storage/logs/laravel.log');
    $this->log('storage/logs/.gitignore');
    $this->log('storage/logs/laravel-2023-01-01.log');

    AdminPanelProvider::$excludedFilesPatterns = ['*2023*'];

    expect(array_keys(listedFiles()))->toBe([$laravel]);
});

it('lists nothing when the log directory is empty', function () {
    expect(listedFiles())->toBe([]);
});

it('lists nothing, without failing, when a log directory does not exist', function () {
    AdminPanelProvider::$logDirs = ["{$this->root}/nowhere"];

    expect(listedFiles())->toBe([]);

    $this->get('/admin/logs')->assertOk();
});

it('skips a log directory that does not exist and reads the others', function () {
    $laravel = $this->log('storage/logs/laravel.log');

    AdminPanelProvider::$logDirs[] = "{$this->root}/nowhere";

    expect(array_keys(listedFiles()))->toBe([$laravel]);
});

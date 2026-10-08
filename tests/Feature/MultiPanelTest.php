<?php

use Filament\Facades\Filament;
use Saade\FilamentLaravelLog\Pages\ViewLog;
use Saade\FilamentLaravelLog\Tests\Fixtures\AdminPanelProvider;
use Saade\FilamentLaravelLog\Tests\Fixtures\SecondPanelProvider;

afterEach(function () {
    SecondPanelProvider::$hasPlugin = false;
});

it('works in an application that has another panel without the plugin', function () {
    expect(Filament::getPanel('second')->hasPlugin('filament-laravel-log'))->toBeFalse();

    $this->get('/admin/logs')->assertOk();
    $this->get('/second/logs')->assertNotFound();
});

it('works when the default panel is the one without the plugin', function () {
    AdminPanelProvider::$isDefault = false;

    $this->refreshApplication();
    $this->enterPanel();

    expect(Filament::getDefaultPanel()->getId())->toBe('second');

    $this->get('/admin/logs')->assertOk();
});

it('gives each panel the slug of its own plugin', function () {
    SecondPanelProvider::$hasPlugin = true;

    $this->refreshApplication();
    $this->enterPanel();

    expect(ViewLog::getSlug(Filament::getPanel('admin')))->toBe('logs')
        ->and(ViewLog::getSlug(Filament::getPanel('second')))->toBe('second-logs')
        ->and(route('filament.second.pages.second-logs', absolute: false))->toBe('/second/second-logs');

    $this->get('/admin/logs')->assertOk();
});

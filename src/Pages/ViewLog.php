<?php

namespace Saade\FilamentLaravelLog\Pages;

use Filament\Pages\Page;

class ViewLog extends Page
{
    protected static string $view = 'filament-laravel-log::view-log';

    protected static function getNavigationGroup(): ?string
    {
        return config('filament-laravel-log.navigationGroup');
    }

    protected static function getNavigationIcon(): string
    {
        return config('filament-laravel-log.navigationIcon');
    }

    protected static function getNavigationLabel(): string
    {
        return config('filament-laravel-log.navigationLabel');
    }

    public static function getSlug(): string
    {
        return config('filament-laravel-log.slug');
    }

    protected function getTitle(): string
    {
        return __('log::filament-laravel-log.page.title');
    }

    public string $content = '';

    public function booted()
    {
        if (!filled(config('filament-laravel-log.logFile'))) {
            throw new \Exception('[Filament Laravel Log]: The log file is not set.');
        }

        $this->content = $this->readLog();
    }

    public function refreshContent(): void
    {
        $this->content = $this->readLog();
        $this->dispatchBrowserEvent('logContentUpdated', ['content' => $this->content]);
    }

    public function clearLogs(): void
    {
        $this->content = $this->writeLog();
        $this->dispatchBrowserEvent('logContentUpdated', ['content' => $this->content]);
    }

    public function readLog(): string
    {
        return file_get_contents(config('filament-laravel-log.logFile'));
    }

    public function writeLog($content = null): string
    {
        file_put_contents(config('filament-laravel-log.logFile'), $content);
        return $this->readLog();
    }
}

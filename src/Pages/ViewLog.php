<?php

namespace Saade\FilamentLaravelLog\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Saade\FilamentLaravelLog\Pages\Concerns\HasSecurity;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ViewLog extends Page
{
    use HasSecurity;

    public static string $view = 'filament-laravel-log::view-log';

    public ?string $logFile = null;

    public function refreshContent(): void
    {
        $content = $this->readLog();
        $this->dispatch('logContentUpdated', ['content' => $content]);
    }

    public function readLog(): string
    {
        if (! $this->logFile) {
            return '';
        }

        return File::get($this->logFile);
    }

    public function writeLog($content = '')
    {
        return File::put($this->logFile, $content);
    }

    public function updatedLogFile()
    {
        $this->refreshContent();
    }

    public function clearLogs(): void
    {
        $this->writeLog();
        $this->refreshContent();
    }

    public function getFinder(): Finder
    {
        return Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreUnreadableDirs()
            ->files()
            ->in(config('filament-laravel-log.logsDir'))
            ->notName(config('filament-laravel-log.exclude'));
    }

    public function getForms(): array
    {
        return [
            'search' => $this->makeForm()
                ->schema($this->getFormSchema())
                ->model($this->getFormModel())
                ->statePath($this->getFormStatePath()),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('logFile')
                ->searchable()
                ->reactive()
                ->disableLabel()
                ->placeholder(__('log::filament-laravel-log.forms.search.placeholder'))
                ->options(fn () => $this->getFileNames($this->getFinder())->take(5))
                ->getSearchResultsUsing(fn (string $query) => $this->getFileNames($this->getFinder()->name("*{$query}*"))),
        ];
    }

    public function getFileNames($files): Collection
    {
        return collect($files)->mapWithKeys(function (SplFileInfo $file) {
            return [$file->getRealPath() => $file->getRealPath()];
        });
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-laravel-log.navigationGroup');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-laravel-log.navigationSort');
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-laravel-log.navigationIcon');
    }

    public static function getNavigationLabel(): string
    {
        return config('filament-laravel-log.navigationLabel');
    }

    public static function getSlug(): string
    {
        return config('filament-laravel-log.slug');
    }

    public function getTitle(): string
    {
        return __('log::filament-laravel-log.page.title');
    }
}

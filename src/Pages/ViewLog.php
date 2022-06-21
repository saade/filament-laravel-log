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

    protected static string $view = 'filament-laravel-log::view-log';

    public ?string $logFile = null;

    public function refreshContent(): void
    {
        $this->dispatchBrowserEvent('logContentUpdated', ['content' => $this->readLog()]);
    }

    public function readLog(): string
    {
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

    protected function getFinder(): Finder
    {
        return Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreUnreadableDirs()
            ->files()
            ->in(config('filament-laravel-log.logsDir'))
            ->notName(config('filament-laravel-log.exclude'));
    }

    protected function getForms(): array
    {
        return [
            'search' => $this->makeForm()
                ->schema($this->getFormSchema())
                ->model($this->getFormModel())
                ->statePath($this->getFormStatePath()),
        ];
    }

    protected function getFormSchema(): array
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

    protected function getFileNames($files): Collection
    {
        return collect($files)->mapWithKeys(function (SplFileInfo $file) {
            return [$file->getRealPath() => $file->getRealPath()];
        });
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('filament-laravel-log.navigationGroup');
    }

    protected static function getNavigationSort(): ?int
    {
        return config('filament-laravel-log.navigationSort');
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
}

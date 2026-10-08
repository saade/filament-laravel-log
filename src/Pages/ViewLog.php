<?php

namespace Saade\FilamentLaravelLog\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use Saade\FilamentLaravelLog\Pages\Concerns\HasActions;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ViewLog extends Page
{
    use HasActions;

    protected static string $view = 'filament-laravel-log::view-log';

    public ?string $logFile = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('logFile')
                    ->label(null)
                    ->placeholder(fn (): string => __('log::filament-laravel-log.page.form.placeholder'))
                    ->live()
                    ->options(
                        fn () => $this->getFileNames($this->getFinder())->take(config('filament-laravel-log.limit'))
                    )
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn (string $query) => $this->getFileNames($this->getFinder()->name("*{$query}*"))
                    )
                    ->afterStateUpdated(fn () => $this->refresh()),
            ]);
    }

    public function read(): string
    {
        $logFile = $this->resolveLogFile();

        if ($logFile === null) {
            $this->logFile = null;

            return '';
        }

        return File::get($logFile);
    }

    public function clear(): void
    {
        if (! $this->isClearable()) {
            return;
        }

        $logFile = $this->resolveLogFile();

        if ($logFile === null) {
            $this->logFile = null;

            return;
        }

        File::put($logFile, '');

        $this->refresh();
    }

    public function refresh(): void
    {
        $this->dispatch('logContentUpdated', content: $this->read());
    }

    /**
     * The real path of the selected file, or null when it is not one of the
     * files this page lists. The value comes from the browser, so it cannot
     * be trusted to be one of the options it was given.
     */
    protected function resolveLogFile(): ?string
    {
        if (blank($this->logFile)) {
            return null;
        }

        $logFile = realpath($this->logFile);

        if (($logFile === false) || (! $this->fileResidesInLogDirs($logFile))) {
            return null;
        }

        return $logFile;
    }

    protected function fileResidesInLogDirs(string $logFile): bool
    {
        $logFile = realpath($logFile);

        if ($logFile === false) {
            return false;
        }

        foreach ($this->getFinder() as $file) {
            if ($file->getRealPath() === $logFile) {
                return true;
            }
        }

        return false;
    }

    protected function getFinder(): Finder
    {
        return Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreUnreadableDirs()
            ->files()
            ->in(FilamentLaravelLogPlugin::get()->getLogDirs())
            ->notName(FilamentLaravelLogPlugin::get()->getExcludedFilesPatterns());
    }

    protected function getFileNames($files): Collection
    {
        return collect($files)->mapWithKeys(function (SplFileInfo $file) {
            return [$file->getRealPath() => $file->getRealPath()];
        });
    }

    public static function getNavigationGroup(): ?string
    {
        return FilamentLaravelLogPlugin::get()->getNavigationGroup();
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentLaravelLogPlugin::get()->getNavigationSort();
    }

    public static function getNavigationIcon(): string
    {
        return FilamentLaravelLogPlugin::get()->getNavigationIcon();
    }

    public static function getNavigationLabel(): string
    {
        return FilamentLaravelLogPlugin::get()->getNavigationLabel();
    }

    public static function getSlug(): string
    {
        return FilamentLaravelLogPlugin::get()->getSlug();
    }

    public function getTitle(): string
    {
        return __('log::filament-laravel-log.page.title');
    }

    public static function canAccess(): bool
    {
        return FilamentLaravelLogPlugin::get()->isAuthorized();
    }
}

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
                    ->label(false)
                    ->placeholder(fn (): string => __('log::filament-laravel-log.page.form.placeholder'))
                    ->live()
                    ->options(
                        fn () => $this->getFileNames($this->getFinder())->take(5)
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
        if (! $this->logFile) {
            return '';
        }

        return File::get($this->logFile);
    }

    public function write($content = ''): void
    {
        if (! $this->logFile) {
            return;
        }

        File::put($this->logFile, $content);
    }

    public function clear(): void
    {
        $this->write();
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->dispatch('logContentUpdated', content: $this->read());
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
}

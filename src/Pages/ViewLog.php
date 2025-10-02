<?php

namespace Saade\FilamentLaravelLog\Pages;

use BackedEnum;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use Saade\FilamentLaravelLog\Pages\Concerns\HasActions;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UnitEnum;

class ViewLog extends Page
{
    use HasActions;

    protected string $view = 'filament-laravel-log::view-log';

    public ?string $logFile = null;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('logFile')
                    ->hiddenLabel()
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
        if (! $this->logFile || ! $this->fileResidesInLogDirs($this->logFile)) {
            $this->logFile = null;

            return '';
        }

        return File::get($this->logFile);
    }

    public function clear(): void
    {
        if (! $this->logFile || ! $this->fileResidesInLogDirs($this->logFile)) {
            $this->logFile = null;

            return;
        }

        File::put($this->logFile, '');

        $this->refresh();
    }

    public function refresh(): void
    {
        $this->dispatch('logContentUpdated', content: $this->read());
    }

    protected function fileResidesInLogDirs(string $logFile): bool
    {
        return collect(FilamentLaravelLogPlugin::get()->getLogDirs())
            ->contains(fn (string $logDir) => str_contains($logFile, $logDir));
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

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return static::$navigationGroup ?? FilamentLaravelLogPlugin::get()->getNavigationGroup();
    }

    public static function getNavigationParentItem(): ?string
    {
        return static::$navigationParentItem ?? FilamentLaravelLogPlugin::get()->getNavigationParentItem();
    }

    public static function getActiveNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return static::$activeNavigationIcon ?? FilamentLaravelLogPlugin::get()->getActiveNavigationIcon();
    }

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return static::$navigationIcon ?? FilamentLaravelLogPlugin::get()->getNavigationIcon();
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? FilamentLaravelLogPlugin::get()->getNavigationLabel();
    }

    public static function getNavigationBadge(): ?string
    {
        return FilamentLaravelLogPlugin::get()->getNavigationBadge();
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        return FilamentLaravelLogPlugin::get()->getNavigationBadgeColor();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return static::$navigationBadgeTooltip ?? FilamentLaravelLogPlugin::get()->getNavigationBadgeTooltip();
    }

    public static function getNavigationSort(): ?int
    {
        return static::$navigationSort ?? FilamentLaravelLogPlugin::get()->getNavigationSort();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return static::$slug ?? FilamentLaravelLogPlugin::get()->getSlug();
    }

    public function getTitle(): string
    {
        return static::$title ?? FilamentLaravelLogPlugin::get()->getTitle();
    }

    public static function canAccess(): bool
    {
        return FilamentLaravelLogPlugin::get()->canAccess();
    }
}

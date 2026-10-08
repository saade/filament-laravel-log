<?php

namespace Saade\FilamentLaravelLog\Pages;

use BackedEnum;
use Filament\Forms;
use Filament\Notifications\Notification;
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
                    ->getOptionLabelUsing(
                        fn (?string $value): ?string => filled($value) ? $this->getFileLabel($value) : null
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

        if (! is_readable($logFile)) {
            $this->notifyFailure('unreadable');

            return '';
        }

        $content = File::get($logFile);

        if (str_ends_with(strtolower($logFile), '.gz') && function_exists('gzdecode')) {
            $content = @gzdecode($content) ?: $content;
        }

        // Livewire sends the content as JSON, which refuses invalid UTF-8.
        return mb_scrub($content, 'UTF-8');
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

        if (! is_writable($logFile)) {
            $this->notifyFailure('unwritable');

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
     * The selected file comes from the browser, so it is only trusted when
     * it is one of the files this page lists.
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

    protected function notifyFailure(string $reason): void
    {
        Notification::make()
            ->danger()
            ->title(__("log::filament-laravel-log.notifications.{$reason}"))
            ->send();
    }

    protected function getFinder(): Finder
    {
        $finder = Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreUnreadableDirs()
            ->files()
            ->notName(FilamentLaravelLogPlugin::get()->getExcludedFilesPatterns())
            ->sortByModifiedTime()
            ->reverseSorting();

        $logDirs = array_filter(FilamentLaravelLogPlugin::get()->getLogDirs(), is_dir(...));

        // A finder with no directory to look in throws when it is read.
        return $logDirs ? $finder->in($logDirs) : $finder->append([]);
    }

    protected function getFileNames($files): Collection
    {
        return collect($files)->mapWithKeys(function (SplFileInfo $file) {
            return [$file->getRealPath() => $this->getFileLabel($file->getRealPath())];
        });
    }

    /**
     * The path of a file as the picker shows it: from its log directory
     * down, with the name of that directory in front when there are several.
     */
    protected function getFileLabel(string $path): string
    {
        $logDirs = collect(FilamentLaravelLogPlugin::get()->getLogDirs())
            ->map(fn (string $logDir): string | false => realpath($logDir))
            ->filter()
            ->unique()
            ->values();

        $logDir = $logDirs
            ->sortByDesc(fn (string $logDir): int => strlen($logDir))
            ->first(fn (string $logDir): bool => str_starts_with($path, $logDir . DIRECTORY_SEPARATOR));

        if ($logDir === null) {
            return $path;
        }

        $label = substr($path, strlen($logDir) + 1);

        if ($logDirs->count() === 1) {
            return $label;
        }

        $name = basename($logDir);

        // Two directories with the same name could not be told apart.
        return $logDirs->filter(fn (string $logDir): bool => basename($logDir) === $name)->count() > 1
            ? $path
            : $name . DIRECTORY_SEPARATOR . $label;
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
        return static::$slug ?? FilamentLaravelLogPlugin::get($panel)->getSlug();
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

<?php

namespace Saade\FilamentLaravelLog;

use Closure;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class FilamentLaravelLogPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool | Closure $authorizeUsing = true;

    protected string $viewLog = ViewLog::class;

    protected array | Closure $logDirs = [];

    protected array | Closure $excludedFilesPatterns = [];

    protected string | Closure | null $navigationGroup = null;

    protected int | Closure $navigationSort = 1;

    protected string | Closure $navigationIcon = 'heroicon-o-document-text';

    protected string | Closure | null $navigationLabel = null;

    protected string | Closure $slug = 'logs';

    public function getId(): string
    {
        return 'filament-laravel-log';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): FilamentManager | static
    {
        return filament(app(static::class)->getId());
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                $this->viewLog,
            ]);
    }

    public function boot(Panel $panel): void
    {
        if (! $this->getLogDirs()) {
            $this->logDirs([
                storage_path('logs'),
            ]);
        }
    }

    public function authorize(bool | Closure $callback = true): static
    {
        $this->authorizeUsing = $callback;

        return $this;
    }

    public function isAuthorized(): bool
    {
        return $this->evaluate($this->authorizeUsing) === true;
    }

    public function viewLog(string $viewLog): static
    {
        $this->viewLog = $viewLog;

        return $this;
    }

    public function logDirs(array | Closure $logDirs): static
    {
        $this->logDirs = $logDirs;

        return $this;
    }

    public function getLogDirs(): array
    {
        return $this->evaluate($this->logDirs);
    }

    public function excludedFilesPatterns(array | Closure $excludedFilesPatterns): static
    {
        $this->excludedFilesPatterns = $excludedFilesPatterns;

        return $this;
    }

    public function getExcludedFilesPatterns(): array
    {
        return $this->evaluate($this->excludedFilesPatterns);
    }

    public function navigationGroup(string | Closure | null $navigationGroup): static
    {
        $this->navigationGroup = $navigationGroup;

        return $this;
    }

    public function getNavigationGroup(): string
    {
        return $this->evaluate($this->navigationGroup) ?? __('log::filament-laravel-log.navigation.group');
    }

    public function navigationSort(int | Closure $navigationSort): static
    {
        $this->navigationSort = $navigationSort;

        return $this;
    }

    public function getNavigationSort(): int
    {
        return $this->evaluate($this->navigationSort);
    }

    public function navigationIcon(string | Closure $navigationIcon): static
    {
        $this->navigationIcon = $navigationIcon;

        return $this;
    }

    public function getNavigationIcon(): string
    {
        return $this->evaluate($this->navigationIcon);
    }

    public function navigationLabel(string | Closure | null $navigationLabel): static
    {
        $this->navigationLabel = $navigationLabel;

        return $this;
    }

    public function getNavigationLabel(): string
    {
        return $this->evaluate($this->navigationLabel) ?? __('log::filament-laravel-log.navigation.label');
    }

    public function slug(string | Closure $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->evaluate($this->slug);
    }
}

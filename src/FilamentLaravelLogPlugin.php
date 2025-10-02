<?php

namespace Saade\FilamentLaravelLog;

use BackedEnum;
use Closure;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Saade\FilamentLaravelLog\Pages\ViewLog;
use UnitEnum;

class FilamentLaravelLogPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool | Closure $authorizeUsing = true;

    protected string $viewLog = ViewLog::class;

    protected array | Closure $logDirs = [];

    protected array | Closure $excludedFilesPatterns = [];

    protected string | Closure | null $title = null;

    protected string | UnitEnum | Closure | null $navigationGroup = null;

    protected string | Closure | null $navigationParentItem = null;

    protected string | BackedEnum | Closure | null $activeNavigationIcon = null;

    protected string | BackedEnum | Closure | null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected string | Closure | null $navigationBadge = null;

    protected string | array | Closure | null $navigationBadgeColor = null;

    protected string | Closure | null $navigationBadgeTooltip = null;

    protected int | Closure | null $navigationSort = null;

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

    public function canAccess(): bool
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
        return (array) $this->evaluate($this->logDirs);
    }

    public function excludedFilesPatterns(array | Closure $excludedFilesPatterns): static
    {
        $this->excludedFilesPatterns = $excludedFilesPatterns;

        return $this;
    }

    public function getExcludedFilesPatterns(): array
    {
        return (array) $this->evaluate($this->excludedFilesPatterns);
    }

    public function navigationGroup(string | UnitEnum | Closure | null $navigationGroup): static
    {
        $this->navigationGroup = $navigationGroup;

        return $this;
    }

    public function getNavigationGroup(): string | UnitEnum | null
    {
        return $this->evaluate($this->navigationGroup);
    }

    public function navigationParentItem(string | Closure | null $navigationParentItem): static
    {
        $this->navigationParentItem = $navigationParentItem;

        return $this;
    }

    public function getNavigationParentItem(): ?string
    {
        return $this->evaluate($this->navigationParentItem);
    }

    public function activeNavigationIcon(string | BackedEnum | Closure | null $activeNavigationIcon): static
    {
        $this->activeNavigationIcon = $activeNavigationIcon;

        return $this;
    }

    public function getActiveNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return $this->evaluate($this->activeNavigationIcon);
    }

    public function title(string | Closure | null $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->evaluate($this->title) ?? __('log::filament-laravel-log.navigation.label');
    }

    public function navigationBadge(string | Closure | null $navigationBadge): static
    {
        $this->navigationBadge = $navigationBadge;

        return $this;
    }

    public function getNavigationBadge(): ?string
    {
        return $this->evaluate($this->navigationBadge);
    }

    public function navigationBadgeColor(string | array | Closure | null $navigationBadgeColor): static
    {
        $this->navigationBadgeColor = $navigationBadgeColor;

        return $this;
    }

    public function getNavigationBadgeColor(): string | array | null
    {
        return $this->evaluate($this->navigationBadgeColor);
    }

    public function navigationBadgeTooltip(string | Closure | null $navigationBadgeTooltip): static
    {
        $this->navigationBadgeTooltip = $navigationBadgeTooltip;

        return $this;
    }

    public function getNavigationBadgeTooltip(): ?string
    {
        return $this->evaluate($this->navigationBadgeTooltip);
    }

    public function navigationSort(int | Closure | null $navigationSort): static
    {
        $this->navigationSort = $navigationSort;

        return $this;
    }

    public function getNavigationSort(): ?int
    {
        return $this->evaluate($this->navigationSort);
    }

    public function navigationIcon(string | BackedEnum | Closure | null $navigationIcon): static
    {
        $this->navigationIcon = $navigationIcon;

        return $this;
    }

    public function getNavigationIcon(): string | BackedEnum | Htmlable | null
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
        return (string) $this->evaluate($this->slug);
    }
}

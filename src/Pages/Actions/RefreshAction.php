<?php

namespace Saade\FilamentLaravelLog\Pages\Actions;

use Filament\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class RefreshAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'refresh';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->iconButton()->icon('heroicon-o-arrow-path-rounded-square')->color('gray');

        $this->label(fn (): string => __('log::filament-laravel-log.actions.refresh.label'));

        $this->action(fn (ViewLog $livewire) => $livewire->refresh());

        $this->size(ActionSize::Small);

        $this->disabled(
            fn (ViewLog $livewire): bool => ! (bool) $livewire->logFile
        );
    }
}

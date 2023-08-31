<?php

namespace Saade\FilamentLaravelLog\Pages\Actions;

use Filament\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class JumpToStartAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'jumpToStart';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->iconButton()->icon('heroicon-o-arrow-uturn-up')->color('gray');

        $this->label(fn (): string => __('log::filament-laravel-log.actions.jumpToStart.label'));

        $this->livewireClickHandlerEnabled(false);

        $this->size(ActionSize::Small);

        $this->disabled(
            fn (ViewLog $livewire): bool => ! (bool) $livewire->logFile
        );
    }
}

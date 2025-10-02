<?php

namespace Saade\FilamentLaravelLog\Pages\Actions;

use Filament\Actions\Action;
use Filament\Support\Enums\Size;
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

        $this->icon('heroicon-o-arrow-uturn-up')->color('gray');

        $this->label(fn (): string => __('log::filament-laravel-log.actions.jumpToStart.label'));

        $this->size(Size::Small);

        $this->livewireClickHandlerEnabled(false);

        $this->disabled(
            fn (ViewLog $livewire): bool => ! (bool) $livewire->logFile
        );
    }
}

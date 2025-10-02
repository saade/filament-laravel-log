<?php

namespace Saade\FilamentLaravelLog\Pages\Actions;

use Filament\Actions\Action;
use Filament\Support\Enums\Size;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class JumpToEndAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'jumpToEnd';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-arrow-uturn-down')->color('gray');

        $this->label(fn (): string => __('log::filament-laravel-log.actions.jumpToEnd.label'));

        $this->size(Size::Small);

        $this->livewireClickHandlerEnabled(false);

        $this->disabled(
            fn (ViewLog $livewire): bool => ! (bool) $livewire->logFile
        );
    }
}

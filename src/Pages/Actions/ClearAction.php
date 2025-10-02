<?php

namespace Saade\FilamentLaravelLog\Pages\Actions;

use Filament\Actions\Action;
use Filament\Support\Enums\Size;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class ClearAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'clear';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-trash')->color('danger');

        $this->label(fn (): string => __('log::filament-laravel-log.actions.clear.label'));

        $this->size(Size::Small);

        $this->requiresConfirmation()
            ->modalHeading(fn (): string => __('log::filament-laravel-log.actions.clear.modal.heading'))
            ->modalDescription(fn (): string => __('log::filament-laravel-log.actions.clear.modal.description'))
            ->modalSubmitActionLabel(fn (): string => __('log::filament-laravel-log.actions.clear.modal.actions.confirm'));

        $this->action(fn (ViewLog $livewire) => $livewire->clear());

        $this->visible(
            fn (ViewLog $livewire): bool => $livewire->isClearable()
        );

        $this->disabled(
            fn (ViewLog $livewire): bool => ! (bool) $livewire->logFile
        );
    }
}

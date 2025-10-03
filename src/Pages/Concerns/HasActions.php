<?php

namespace Saade\FilamentLaravelLog\Pages\Concerns;

use Closure;
use Filament\Actions\Action;
use Filament\Support\Concerns\EvaluatesClosures;
use Saade\FilamentLaravelLog\Pages\Actions\ClearAction;
use Saade\FilamentLaravelLog\Pages\Actions\JumpToEndAction;
use Saade\FilamentLaravelLog\Pages\Actions\JumpToStartAction;
use Saade\FilamentLaravelLog\Pages\Actions\RefreshAction;

trait HasActions
{
    use EvaluatesClosures;

    protected bool | Closure $isClearable = true;

    protected ?Closure $modifyClearActionUsing = null;

    protected ?Closure $modifyJumpToStartActionUsing = null;

    protected ?Closure $modifyJumpToEndActionUsing = null;

    protected ?Closure $modifyRefreshActionUsing = null;

    public function clearAction(): Action
    {
        $action = ClearAction::make();

        if ($this->modifyClearActionUsing) {
            $action = $this->evaluate($this->modifyClearActionUsing, [
                'action' => $action,
            ]) ?? $action;
        }

        return $action;
    }

    public function jumpToStartAction(): Action
    {
        $action = JumpToStartAction::make();

        if ($this->modifyJumpToStartActionUsing) {
            $action = $this->evaluate($this->modifyJumpToStartActionUsing, [
                'action' => $action,
            ]) ?? $action;
        }

        $action->extraAttributes([
            'x-on:click' => 'jumpToStart',
            ...$action->getExtraAttributes(),
        ]);

        return $action;
    }

    public function jumpToEndAction(): Action
    {
        $action = JumpToEndAction::make();

        if ($this->modifyJumpToEndActionUsing) {
            $action = $this->evaluate($this->modifyJumpToEndActionUsing, [
                'action' => $action,
            ]) ?? $action;
        }

        $action->extraAttributes([
            'x-on:click' => 'jumpToEnd',
            ...$action->getExtraAttributes(),
        ]);

        return $action;
    }

    public function refreshAction(): Action
    {
        $action = RefreshAction::make();

        if ($this->modifyRefreshActionUsing) {
            $action = $this->evaluate($this->modifyRefreshActionUsing, [
                'action' => $action,
            ]) ?? $action;
        }

        return $action;
    }

    public function modifyClearAction(?Closure $callback): static
    {
        $this->modifyClearActionUsing = $callback;

        return $this;
    }

    public function modifyJumpToStartAction(?Closure $callback): static
    {
        $this->modifyJumpToStartActionUsing = $callback;

        return $this;
    }

    public function modifyJumpToEndAction(?Closure $callback): static
    {
        $this->modifyJumpToEndActionUsing = $callback;

        return $this;
    }

    public function modifyRefreshAction(?Closure $callback): static
    {
        $this->modifyRefreshActionUsing = $callback;

        return $this;
    }

    public function isClearable(): bool
    {
        return $this->evaluate($this->isClearable);
    }
}

@php
    use Filament\Support\Facades\FilamentAsset;
@endphp

<x-filament-panels::page>
    <div
        x-load
        x-load-css="[@js(FilamentAsset::getStyleHref('filament-laravel-log-styles', 'saade/filament-laravel-log'))]"
        x-load-src="{{ FilamentAsset::getAlpineComponentSrc('filament-laravel-log-alpine', 'saade/filament-laravel-log') }}"
        x-data="editor({
            maxLines: @js(config('filament-laravel-log.maxLines')),
            minLines: @js(config('filament-laravel-log.minLines')),
            fontSize: @js(config('filament-laravel-log.fontSize'))
        })"
        class="fi-log"
    >
        <div class="fi-log-toolbar">
            <div class="fi-log-file">
                {{ $this->form }}
            </div>

            <div class="fi-log-actions">
                {{ $this->jumpToStartAction }}
                {{ $this->refreshAction }}
                {{ $this->jumpToEndAction }}
                {{ $this->clearAction }}
            </div>
        </div>

        <div
            class="fi-log-editor ace-filament"
            x-ref="editor"
            wire:ignore
        ></div>
    </div>
</x-filament-panels::page>

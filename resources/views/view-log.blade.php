<x-filament::page>
    <div
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-laravel-log', 'saade/filament-laravel-log') }}"
        ax-load-css="{{ \Filament\Support\Facades\FilamentAsset::getStyleHref('filament-laravel-log-styles', 'saade/filament-laravel-log') }}"
        x-data="editor({
            maxLines: @js(config('filament-laravel-log.maxLines')),
            minLines: @js(config('filament-laravel-log.minLines')),
            fontSize: @js(config('filament-laravel-log.fontSize'))
        })"
    >
        <div class="flex items-center justify-between gap-6">
            <div class="w-full">
                {{ $this->form }}
            </div>
            <div class="flex items-center space-x-2 shrink-0">
                {{ $this->jumpToStartAction }}
                {{ $this->refreshAction }}
                {{ $this->jumpToEndAction }}
                {{ $this->clearAction }}
            </div>
        </div>

        <div
            class="mt-4 rounded-lg ace-filament"
            x-ref="editor"
            wire:ignore
        ></div>
    </div>
</x-filament::page>

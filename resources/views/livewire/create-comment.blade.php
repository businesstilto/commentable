<div>
    <form wire:submit="create">
        {{ $this->form }}

        <div @if($buttonPosition === 'right') class="flex justify-end" @endif>
            <x-filament::button type="submit" class="mt-4">
                {{ __('commentable::translations.buttons.post') }}
            </x-filament::button>
        </div>
    </form>
</div>

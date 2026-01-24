<div>
    <form wire:submit="create">
        {{ $this->form }}

        <div @if($buttonPosition === 'right') class="fi-create-comment-actions" @endif>
            <x-filament::button type="submit" class="fi-create-comment-submit">
                {{ __('commentable::translations.buttons.post') }}
            </x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>

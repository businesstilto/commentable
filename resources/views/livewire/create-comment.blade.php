<div>
    <div x-data="{ submitting: false }">
        {{ $this->form }}

        <div @if($buttonPosition === 'right') class="fi-create-comment-actions" @endif>
            <x-filament::button
                wire:click="create"
                x-on:click="submitting = true"
                ::disabled="submitting"
                class="fi-create-comment-submit"
            >
                {{ __('commentable::translations.buttons.post') }}
            </x-filament::button>
        </div>
    </div>

    <x-filament-actions::modals />
</div>

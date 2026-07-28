<div>
    @can('create', [config('commentable.comment.model'), $record])
        <form wire:submit="create"
            x-on:keydown.ctrl.enter.capture.prevent.stop="$el.requestSubmit()"
            x-on:keydown.meta.enter.capture.prevent.stop="$el.requestSubmit()">
            {{ $this->form }}

            <div @if($buttonPosition === 'right') class="fi-create-comment-actions" @endif>
                <x-filament::button
                    type="submit"
                    class="fi-create-comment-submit"
                >
                    {{ __('commentable::translations.buttons.post') }}
                </x-filament::button>
            </div>
        </form>

        <x-filament-actions::modals />
    @endcan
</div>

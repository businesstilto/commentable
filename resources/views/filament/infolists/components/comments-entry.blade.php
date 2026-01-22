<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="">
        @livewire('commentable::livewire.create-comment', [
            'record' => $record,
            'toolbarButtons' => $getToolbarButtons(),
            'buttonPosition' => $getButtonPosition(),
            'isMarkdownEditor' => $isMarkdownEditor(),
        ])
    </div>

    <div class="pt-4 space-y-6">
        @if (!$record->comments->isEmpty())
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold">{{ $record->comments->count() }} @if ($record->comments->count() == 1)
                        {{ __('commentable::translations.comment_singular') }}
                    @else
                        {{ __('commentable::translations.comment_plural') }}
                    @endif
                </h3>
            </div>
        @endif

        @if ($record->comments->isEmpty())
            <x-filament::empty-state icon="heroicon-o-chat-bubble-left-ellipsis" icon-color="gray" class="mt-4">
                <x-slot name="heading">
                    {{ __('commentable::translations.empty_state.heading') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('commentable::translations.empty_state.description') }}
                </x-slot>
            </x-filament::empty-state>
        @endif

        @foreach ($record->comments as $comment)
            @livewire('commentable::livewire.comment', ['comment' => $comment], key($comment->id))
        @endforeach
    </div>
</x-dynamic-component>

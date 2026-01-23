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

    <div wire:key="comments-list-{{ $record->id }}" class="space-y-6"
        @if ($shouldPoll) wire:poll @elseif ($pollingInterval) wire:poll.{{ $pollingInterval }} @endif>
        @foreach ($record->comments as $comment)
            @livewire(
                'commentable::livewire.comment',
                [
                    'comment' => $comment,
                    'buttonPosition' => $buttonPosition,
                    'isMarkdownEditor' => $isMarkdownEditor,
                    'toolbarButtons' => $toolbarButtons,
                    'buttonPosition' => $buttonPosition,
                    'isMarkdownEditor' => $isMarkdownEditor,
                    'mentions' => $mentions,
                    'fileAttachmentsDisk' => $fileAttachmentsDisk,
                    'fileAttachmentsDirectory' => $fileAttachmentsDirectory,
                    'fileAttachmentsAcceptedFileTypes' => $fileAttachmentsAcceptedFileTypes,
                    'fileAttachmentsMaxSize' => $fileAttachmentsMaxSize,
                    'isNestable' => $isNestable,
                ],
                key('comment-' . $comment->id)
            )
        @endforeach
    </div>
</div>

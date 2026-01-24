<div class="fi-comment-list">
    @if (!$record->comments->isEmpty() && $shouldShowCommentCount)
        <div class="fi-comment-list-header">
            <h3 class="fi-comment-list-title">{{ $record->comments->count() }} @if ($record->comments->count() == 1)
                    {{ __('commentable::translations.comment_singular') }}
                @else
                    {{ __('commentable::translations.comment_plural') }}
                @endif
            </h3>
        </div>
    @endif

    @if ($record->comments->isEmpty())
        <x-filament::empty-state icon="heroicon-o-chat-bubble-left-ellipsis" icon-color="gray" class="fi-comment-list-empty">
            <x-slot name="heading">
                {{ __('commentable::translations.empty_state.heading') }}
            </x-slot>

            <x-slot name="description">
                {{ __('commentable::translations.empty_state.description') }}
            </x-slot>
        </x-filament::empty-state>
    @endif

    <div wire:key="comments-list-{{ $record->id }}" class="fi-comment-list-items"
        @if ($shouldPoll) wire:poll @elseif ($pollingInterval) wire:poll.{{ $pollingInterval }} @endif>
        @foreach ($record->comments->whereNull('parent_id') as $comment)
            <livewire:commentable::livewire.comment
                :record="$record"
                :comment="$comment"
                :button-position="$buttonPosition"
                :is-markdown-editor="$isMarkdownEditor"
                :toolbar-buttons="$toolbarButtons"
                :file-attachments-disk="$fileAttachmentsDisk"
                :file-attachments-directory="$fileAttachmentsDirectory"
                :file-attachments-accepted-file-types="$fileAttachmentsAcceptedFileTypes"
                :file-attachments-max-size="$fileAttachmentsMaxSize"
                :is-nestable="$isNestable"
                :depth="0"
                :key="'comment-' . $comment->id"
            />
        @endforeach
    </div>
</div>

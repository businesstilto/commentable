<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry"
    class="fi-commentable"
>
    <livewire:commentable::livewire.create-comment
        :record="$record"
        :button-position="$getButtonPosition()"
        :is-markdown-editor="$isMarkdownEditor()"
        :file-attachments-disk="$getFileAttachmentsDisk()"
        :file-attachments-directory="$getFileAttachmentsDirectory()"
        :file-attachments-accepted-file-types="$getFileAttachmentsAcceptedFileTypes()"
        :file-attachments-max-size="$getFileAttachmentsMaxSize()"
        :enable-mentions="$getMentionsEnabled()"
        :toolbar-buttons="$getToolbarButtons()"
        :key="'create-comment-' . $record->id"
    />

    <livewire:commentable::livewire.comment-list
        :record="$record"
        :button-position="$getButtonPosition()"
        :is-markdown-editor="$isMarkdownEditor()"
        :should-show-comment-count="$shouldShowCommentCount()"
        :file-attachments-disk="$getFileAttachmentsDisk()"
        :file-attachments-directory="$getFileAttachmentsDirectory()"
        :file-attachments-accepted-file-types="$getFileAttachmentsAcceptedFileTypes()"
        :file-attachments-max-size="$getFileAttachmentsMaxSize()"
        :should-poll="$shouldPoll()"
        :polling-interval="$getPollingInterval()"
        :is-nestable="$isNestable()"
        :enable-mentions="$getMentionsEnabled()"
        :toolbar-buttons="$getToolbarButtons()"
        :key="'comment-list-' . $record->id"
    />
</x-dynamic-component>

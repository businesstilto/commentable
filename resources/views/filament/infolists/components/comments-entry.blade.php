<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div wire:key="create-comment-{{ $record->id }}">
        @livewire('commentable::livewire.create-comment', [
            'record' => $record,
            'buttonPosition' => $getButtonPosition(),
            'isMarkdownEditor' => $isMarkdownEditor(),
            'fileAttachmentsDisk' => $getFileAttachmentsDisk(),
            'fileAttachmentsDirectory' => $getFileAttachmentsDirectory(),
            'fileAttachmentsAcceptedFileTypes' => $getFileAttachmentsAcceptedFileTypes(),
            'fileAttachmentsMaxSize' => $getFileAttachmentsMaxSize(),
            'mentions' => $getMentions(),
            'toolbarButtons' => $getToolbarButtons(),
        ])
    </div>

    @livewire(
        'commentable::livewire.comment-list',
        [
            'record' => $record,
            'buttonPosition' => $getButtonPosition(),
            'isMarkdownEditor' => $isMarkdownEditor(),
            'shouldShowCommentCount' => $shouldShowCommentCount(),
            'fileAttachmentsDisk' => $getFileAttachmentsDisk(),
            'fileAttachmentsDirectory' => $getFileAttachmentsDirectory(),
            'fileAttachmentsAcceptedFileTypes' => $getFileAttachmentsAcceptedFileTypes(),
            'fileAttachmentsMaxSize' => $getFileAttachmentsMaxSize(),
            'shouldPoll' => $shouldPoll(),
            'pollingInterval' => $getPollingInterval(),
            'isNestable' => $isNestable(),
            'mentions' => $getMentions(),
            'toolbarButtons' => $getToolbarButtons(),
        ],
        key('comment-list-' . $record->id)
    )
</x-dynamic-component>

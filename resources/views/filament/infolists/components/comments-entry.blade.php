<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div wire:key="create-comment-{{ $record->id }}">
        @livewire('commentable::livewire.create-comment', [
            'record' => $record,
            'toolbarButtons' => $getToolbarButtons(),
            'buttonPosition' => $getButtonPosition(),
            'isMarkdownEditor' => $isMarkdownEditor(),
            'fileAttachmentsDisk' => $getFileAttachmentsDisk(),
            'fileAttachmentsDirectory' => $getFileAttachmentsDirectory(),
            'fileAttachmentsAcceptedFileTypes' => $getFileAttachmentsAcceptedFileTypes(),
            'fileAttachmentsMaxSize' => $getFileAttachmentsMaxSize(),
        ])
    </div>

    @livewire(
        'commentable::livewire.comment-list',
        [
            'record' => $record,
            'shouldPoll' => $shouldPoll(),
            'pollingInterval' => $getPollingInterval(),
        ],
        key('comment-list-' . $record->id)
    )
</x-dynamic-component>

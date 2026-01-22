<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div wire:key="create-comment-{{ $record->id }}">
        @livewire('commentable::livewire.create-comment', [
            'record' => $record,
            'toolbarButtons' => $getToolbarButtons(),
            'buttonPosition' => $getButtonPosition(),
            'isMarkdownEditor' => $isMarkdownEditor(),
        ])
    </div>

    @livewire('commentable::livewire.comment-list', ['record' => $record], key('comment-list-' . $record->id))
</x-dynamic-component>

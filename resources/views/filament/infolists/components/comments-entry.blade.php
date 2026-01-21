<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="space-y-4 mb-6">
        <p>Nog geen comments...</p>
    </div>

    <div class="border-t pt-4">
        @livewire('commentable::livewire.create-comment', [
            'record' => $record,
            'toolbarButtons' => $getToolbarButtons(),
            'buttonPosition' => $getButtonPosition(),
            'isMarkdownEditor' => $isMarkdownEditor(),
        ])
    </div>
</x-dynamic-component>

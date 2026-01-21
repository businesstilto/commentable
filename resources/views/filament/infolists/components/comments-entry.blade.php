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
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold">{{ $record->comments->count() }} @if ($record->comments->count() == 1)
                    comment
                @else
                    comments
                @endif
            </h3>
        </div>

        @foreach ($record->comments as $comment)
            <div class="space-y-3">
                <div class="flex gap-3">
                    <img src="{{ $comment->author->getCommenterAvatar() }}"
                        alt="{{ $comment->author->getCommenterName() }}" class="w-10 h-10 rounded-full shrink-0">

                    <div class="flex-1 space-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-sm">{{ $comment->author->getCommenterName() }}</span>
                                <span
                                    class="text-gray-500 dark:text-gray-400 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex gap-2">
                                <x-filament::icon-button icon="heroicon-o-pencil-square" size="s"
                                    color="gray"
                                    class="!p-0 !m-0 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200" />

                                <x-filament::icon-button icon="heroicon-o-trash" size="s"
                                    color="gray"
                                    class="!p-0 !m-0 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200" />
                            </div>
                        </div>

                        <p class="text-sm text-gray-700">{!! $comment->body !!}</p>

                        <div class="flex items-center gap-4 text-sm">
                            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                <x-filament::icon-button icon="heroicon-o-chat-bubble-left-ellipsis" size="xs"
                                    color="gray"
                                    class="!p-0 !m-0 text-gray-600 dark:text-gray-400 pointer-events-none" />
                                <span>2 replies</span>
                            </span>
                            <button
                                class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-dynamic-component>

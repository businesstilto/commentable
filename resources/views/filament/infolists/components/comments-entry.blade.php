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
                            <div class="flex gap-1">
                                <x-filament::icon-button icon="heroicon-o-pencil-square" size="xs"
                                    tooltip="Bewerken" color="gray"
                                    class="!p-0 !m-0 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200" />

                                @can('delete', $comment)
                                    <x-filament::modal icon="heroicon-s-trash" icon-color="danger" alignment="center"
                                        width="md">
                                        <x-slot name="trigger">
                                            <x-filament::icon-button icon="heroicon-o-trash" size="xs"
                                                tooltip="Verwijderen" color="gray"
                                                class="!p-0 !m-0 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200" />
                                        </x-slot>

                                        <x-slot name="heading">
                                            {{ __('commentable::translations.delete_confirmation.heading') }}
                                        </x-slot>

                                        <x-slot name="description">
                                            {{ __('commentable::translations.delete_confirmation.description') }}
                                        </x-slot>

                                        <x-slot name="footerActions">
                                            <div class="flex w-full gap-3">
                                                <x-filament::button color="gray" class="basis-1/2">
                                                    {{ __('commentable::translations.delete_confirmation.cancel') }}
                                                </x-filament::button>
                                                <x-filament::button wire:click="delete({{ $comment->id }})" color="danger"
                                                    class="basis-1/2">
                                                    {{ __('commentable::translations.delete_confirmation.delete') }}
                                                </x-filament::button>
                                            </div>
                                        </x-slot>
                                    </x-filament::modal>
                                @endcan
                            </div>
                        </div>

                        <p class="text-sm text-gray-700">{!! $comment->body !!}</p>

                        <div class="flex items-center gap-4 text-sm">
                            <button
                                class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">{{ __('commentable::translations.reply') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-dynamic-component>

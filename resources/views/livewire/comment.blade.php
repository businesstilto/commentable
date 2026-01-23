@props(['comment'])
@use('\Filament\Forms\Components\RichEditor\RichContentRenderer')

<div class="space-y-4">
    <div class="space-y-3">
        <div class="flex gap-4">
            <img src="{{ $comment->author->getCommenterAvatar() }}" alt="{{ $comment->author->getCommenterName() }}"
                class="w-10 h-10 rounded-full shrink-0">

            <div class="flex-1 space-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-semibold text-sm">{{ $comment->author->getCommenterName() }}</span>
                        <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">
                            @if ($comment->created_at->eq($comment->updated_at))
                                {{ $comment->created_at->diffForHumans() }}
                            @else
                                {{ $comment->created_at->diffForHumans() }} {{ __('commentable::translations.edited') }}
                            @endif
                        </span>
                    </div>
                    <div class="flex gap-1">
                        @if ($isNestable && !$isReplying)
                            @if (auth()->check() &&
                                    (auth()->id() !== $comment->author->getKey() ||
                                        get_class(auth()->user()) !== $comment->author->getMorphClass()) &&
                                    auth()->user()->can('reply', $comment))
                                <x-filament::icon-button icon="bi-reply" size="xs" wire:click="openReply"
                                    tooltip="{{ __('commentable::translations.reply') }}" color="gray"
                                    class="!p-0 !m-0 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-500" />
                            @endif
                        @endif

                        @canany(['update', 'delete'], $comment)
                            <x-filament::dropdown>
                                <x-slot name="trigger">
                                    @if (!$isEditing)
                                        <x-filament::icon-button icon="heroicon-o-ellipsis-vertical" size="xs"
                                            color="gray"
                                            class="!p-0 !m-0 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200" />
                                    @endif
                                </x-slot>

                                <x-filament::dropdown.list>
                                    @can('update', $comment)
                                        <x-filament::dropdown.list.item icon="heroicon-o-pencil-square" wire:click="openEdit">
                                            {{ __('commentable::translations.dropdown.edit') }}
                                        </x-filament::dropdown.list.item>
                                    @endcan

                                    @can('delete', $comment)
                                        <x-filament::modal icon="heroicon-s-trash" icon-color="danger" alignment="center"
                                            width="md">
                                            <x-slot name="trigger">
                                                <x-filament::dropdown.list.item icon="heroicon-o-trash" color="danger">
                                                    {{ __('commentable::translations.dropdown.delete') }}
                                                </x-filament::dropdown.list.item>
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
                                                    <x-filament::button wire:click="delete" color="danger" class="basis-1/2">
                                                        {{ __('commentable::translations.delete_confirmation.confirm') }}
                                                    </x-filament::button>
                                                </div>
                                            </x-slot>
                                        </x-filament::modal>
                                    @endcan
                                </x-filament::dropdown.list>
                            </x-filament::dropdown>
                        @endcanany
                    </div>
                </div>

                @if (!$isEditing)
                    <div
                        class="prose max-w-none dark:prose-invert prose-p:text-gray-700 dark:prose-p:text-gray-300 text-sm">
                        @if ($isMarkdownEditor)
                            {!! str($comment->body)->markdown()->sanitizeHtml() !!}
                        @else
                            {!! RichContentRenderer::make($comment->body)->toHtml() !!}
                        @endif
                    </div>
                @else
                    <form wire:submit="edit">
                        {{ $this->form }}

                        <div @if ($buttonPosition === 'right') class="flex justify-end gap-3 mt-4" @endif>
                            <x-filament::button type="button" color="gray" wire:click="cancelEdit">
                                {{ __('commentable::translations.buttons.cancel') }}
                            </x-filament::button>
                            <x-filament::button type="submit">
                                {{ __('commentable::translations.buttons.edit') }}
                            </x-filament::button>
                        </div>
                    </form>
                @endif

                @if ($isNestable && $isReplying)
                    <div class="mt-4">
                        <form wire:submit="reply">
                            {{ $this->form }}

                            <div @if ($buttonPosition === 'right') class="flex justify-end gap-3 mt-4" @endif>
                                <x-filament::button wire:click="cancelReply" color="gray" type="button">
                                    {{ __('commentable::translations.buttons.cancel') }}
                                </x-filament::button>
                                <x-filament::button type="submit">
                                    {{ __('commentable::translations.buttons.reply') }}
                                </x-filament::button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

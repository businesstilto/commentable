@props(['comment'])
@use('\Filament\Forms\Components\RichEditor\RichContentRenderer')

<div>
    <div class="space-y-3">
        <div class="flex gap-3">
            <img src="{{ $comment->author->getCommenterAvatar() }}" alt="{{ $comment->author->getCommenterName() }}"
                class="w-10 h-10 rounded-full shrink-0">

            <div class="flex-1 space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-semibold text-sm">{{ $comment->author->getCommenterName() }}</span>
                        <span
                            class="text-gray-500 dark:text-gray-400 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex gap-1">
                        @canany(['update', 'delete'], $comment)
                            <x-filament::dropdown>
                                <x-slot name="trigger">
                                    <x-filament::icon-button icon="heroicon-o-ellipsis-vertical" size="xs"
                                        color="gray"
                                        class="!p-0 !m-0 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200" />
                                </x-slot>

                                <x-filament::dropdown.list>
                                    @can('update', $comment)
                                        <x-filament::dropdown.list.item icon="heroicon-o-pencil-square">
                                            Bewerken
                                        </x-filament::dropdown.list.item>
                                    @endcan

                                    @can('delete', $comment)
                                        <x-filament::modal icon="heroicon-s-trash" icon-color="danger" alignment="center"
                                            width="md">
                                            <x-slot name="trigger">
                                                <x-filament::dropdown.list.item icon="heroicon-o-trash" color="danger">
                                                    Verwijderen
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

                <p class="text-sm text-gray-700 prose dark:prose-invert">
                    @if ($isMarkdownEditor)
                        {!! \Illuminate\Support\Str::markdown(e($comment->content)) !!}
                    @else
                        {!! RichContentRenderer::make($comment->body)->toHtml() !!}
                    @endif
                </p>

                <div class="flex items-center gap-4 text-sm">
                    <button
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">{{ __('commentable::translations.reply') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

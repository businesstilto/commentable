@props(['comment', 'depth' => 0])
@use('\Filament\Forms\Components\RichEditor\RichContentRenderer')

<div class="space-y-4">
    <div class="space-y-3">
        <div class="fi-comment-header">
            <img src="{{ $comment->author->getCommenterAvatar() }}" alt="{{ $comment->author->getCommenterName() }}"
                class="fi-comment-avatar">

            <div class="fi-comment-content space-y-1">
                <div class="fi-comment-meta">
                    <div class="fi-comment-meta-author">
                        <span class="fi-comment-meta-author-inner">{{ $comment->author->getCommenterName() }}</span>
                        <span class="fi-comment-date">
                            @if ($comment->created_at->eq($comment->updated_at))
                                {{ $comment->created_at->diffForHumans() }}
                            @else
                                {{ $comment->created_at->diffForHumans() }} {{ __('commentable::translations.edited') }}
                            @endif
                        </span>
                    </div>
                    <div class="fi-comment-actions">
                        @if ($isNestable && !$isReplying && $depth < 2)
                            @if (auth()->check() &&
                                    (auth()->id() !== $comment->author->getKey() ||
                                        get_class(auth()->user()) !== $comment->author->getMorphClass()) &&
                                    auth()->user()->can('reply', $comment))
                                <x-filament::icon-button icon="bi-reply" size="xs" wire:click="openReply"
                                    tooltip="{{ __('commentable::translations.reply') }}" color="gray"
                                    class="fi-comment-action-reply" />
                            @endif
                        @endif

                        @canany(['update', 'delete'], $comment)
                            <x-filament::dropdown placement="bottom-start">
                                <x-slot name="trigger">
                                    @if (!$isEditing)
                                        <x-filament::icon-button icon="heroicon-o-ellipsis-vertical" size="xs"
                                            color="gray" class="fi-comment-action-menu" />
                                    @endif
                                </x-slot>

                                <x-filament::dropdown.list>
                                    @can('update', $comment)
                                        <x-filament::dropdown.list.item icon="heroicon-o-pencil-square" wire:click="openEdit">
                                            {{ __('commentable::translations.dropdown.edit') }}
                                        </x-filament::dropdown.list.item>
                                    @endcan

                                    @can('delete', $comment)
                                        <x-filament::modal id="delete-comment" icon="heroicon-s-trash" icon-color="danger"
                                            alignment="center" width="md">
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
                                                <div class="fi-comment-delete-actions">
                                                    <x-filament::button wire:click="cancel" color="gray"
                                                        class="fi-comment-delete-cancel">
                                                        {{ __('commentable::translations.delete_confirmation.cancel') }}
                                                    </x-filament::button>
                                                    <x-filament::button wire:click="delete" color="danger"
                                                        class="fi-comment-delete-confirm">
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
                    <div class="fi-comment-body prose">
                        @if ($isMarkdownEditor)
                            {!! str($comment->body)->markdown()->sanitizeHtml() !!}
                        @else
                            {!! RichContentRenderer::make($comment->body)->toHtml() !!}
                        @endif
                    </div>
                @else
                    <form wire:submit="edit">
                        {{ $this->form }}

                        <div
                            @if ($buttonPosition === 'right') class="fi-comment-edit-actions-right" @else class="fi-comment-edit-actions" @endif>
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

                            <div
                                @if ($buttonPosition === 'right') class="fi-comment-edit-actions-right" @else class="fi-comment-edit-actions" @endif>
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

    @if ($isNestable && $depth < 2 && $comment->relationLoaded('replies') && $comment->replies->isNotEmpty())
        <div class="fi-comment-replies">
            @foreach ($comment->replies as $reply)
                <livewire:commentable::livewire.comment
                    :record="$record"
                    :comment="$reply"
                    :button-position="$buttonPosition"
                    :is-markdown-editor="$isMarkdownEditor"
                    :toolbar-buttons="$toolbarButtons"
                    :file-attachments-disk="$fileAttachmentsDisk"
                    :file-attachments-directory="$fileAttachmentsDirectory"
                    :file-attachments-accepted-file-types="$fileAttachmentsAcceptedFileTypes"
                    :file-attachments-max-size="$fileAttachmentsMaxSize"
                    :is-nestable="$isNestable"
                    :depth="$depth + 1"
                    :key="'comment-' . $reply->id"
                />
            @endforeach
        </div>
    @endif
</div>

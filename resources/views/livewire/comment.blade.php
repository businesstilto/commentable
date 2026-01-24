@props(['comment', 'depth' => 0])
@use('\Filament\Forms\Components\RichEditor\RichContentRenderer')

<div class="space-y-4">
    <div class="space-y-3">
        <div class="fi-comment-header">

            <img src="{{ $comment->author ? $comment->author->getCommenterAvatar() : 'https://ui-avatars.com/api/?name=Unknown&color=FFFFFF&background=71717b' }}"
                alt="{{ $comment->author ? $comment->author->getCommenterName() : 'Unknown' }}" class="fi-comment-avatar">

            <div class="fi-comment-content space-y-1">
                <div class="fi-comment-meta">
                    <div class="fi-comment-meta-author">
                        <span
                            class="fi-comment-meta-author-inner">{{ $comment->author ? $comment->author->getCommenterName() : 'Unknown' }}</span>
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
                                {{ $this->replyAction }}
                            @endif
                        @endif

                        @canany(['update', 'delete'], $comment)
                            <div>
                                <x-filament-actions::group size="xs" color="gray" :actions="[$this->editAction, $this->deleteAction]" />

                                <x-filament-actions::modals />
                            </div>
                        @endcanany
                    </div>
                </div>

                @if (!$isEditing)
                    <div class="fi-comment-body prose">
                        @if ($isMarkdownEditor)
                            {!! str($comment->body)->markdown()->sanitizeHtml() !!}
                        @else
                            @php
                                $renderer = RichContentRenderer::make($comment->body);
                                
                                if (isset($this->fileAttachmentsDisk)) {
                                    $renderer = $renderer->fileAttachmentsDisk($this->fileAttachmentsDisk);
                                }
                                if (isset($this->fileAttachmentsVisibility)) {
                                    $renderer = $renderer->fileAttachmentsVisibility($this->fileAttachmentsVisibility);
                                }
                            @endphp
                            @if (method_exists($record, 'getRenderMentionProviders'))
                                {!! $renderer->mentions($record->getRenderMentionProviders())->toHtml() !!}
                            @else
                                {!! $renderer->toHtml() !!}
                            @endif
                        @endif
                    </div>
                @else
                    <form wire:submit="edit" class="fi-comment-edit-form">
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

                        <x-filament-actions::modals />
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($isNestable && $depth < 2 && $comment->relationLoaded('replies') && $comment->replies->isNotEmpty())
        <div class="fi-comment-replies">
            @foreach ($comment->replies as $reply)
                <livewire:commentable::livewire.comment :record="$record" :comment="$reply" :button-position="$buttonPosition"
                    :is-markdown-editor="$isMarkdownEditor" :toolbar-buttons="$toolbarButtons" :file-attachments-disk="$fileAttachmentsDisk" :file-attachments-directory="$fileAttachmentsDirectory" :file-attachments-accepted-file-types="$fileAttachmentsAcceptedFileTypes"
                    :file-attachments-max-size="$fileAttachmentsMaxSize" :is-nestable="$isNestable" :enable-mentions="$enableMentions" :depth="$depth + 1" :key="'comment-' . $reply->id" />
            @endforeach
        </div>
    @endif
</div>

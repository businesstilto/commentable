<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Tilto\Commentable\Livewire\CommentList;

trait Reply
{
    public bool $isReplying = false;

    public function replyButton(): Action
    {
        return Action::make('reply')
            ->icon('bi-reply')
            ->size('xs')
            ->color('gray')
            ->iconButton()
            ->label(false)
            ->tooltip(__('commentable::translations.reply'))
            ->action('openReply');
    }

    public function openReply()
    {
        if (! auth()->user()?->can('reply', $this->comment)) {
            return;
        }

        $this->isReplying = true;

        $this->form->fill();
    }

    public function cancelReply()
    {
        $this->isReplying = false;

        $this->form->fill();
    }

    public function reply(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && ! empty($data['body'])) {
            $this->record->comment(
                $this->record,
                $this->comment->id,
                $data['body'],
                $user
            );

            $this->dispatch('comment-replied')->to(CommentList::class);

            $this->form->fill();

            $this->isReplying = false;
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }
    }
}

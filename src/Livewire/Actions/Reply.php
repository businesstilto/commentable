<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Notifications\Notification;

trait Reply
{
    public bool $isReplying = false;

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
            $this->record->comment(parent_id: $this->comment->id, body: $data['body'], author: $user);

            $this->dispatch('comment-replied');

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

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

        $this->form->fill([
            'body' => $this->comment->body,
        ]);

        $this->isReplying = true;

        $this->js('document.body.click()');
    }

    public function cancelReply()
    {
        $this->isReplying = false;

        $this->form->fill([
            'body' => '',
        ]);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && ! empty($data['body'])) {
            $this->record->comment(parent_id: $this->comment->id, body: $data['body'], user: $user);

            $this->dispatch('comment-created');

            $this->form->fill(['body' => '']);

            $this->isReplying = false;
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }
    }
}

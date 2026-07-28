<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Notifications\Notification;
use Tilto\Commentable\Livewire\CommentList;

trait Create
{
    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && ! empty($data['body'])) {
            $this->record->comment(
                $this->record,
                null,
                $data['body'],
                $user
            );

            $this->dispatch('comment-created')->to(CommentList::class);

            $this->form->fill();
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }
    }
}

<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Notifications\Notification;

trait Create
{
    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && !empty($data['body'])) {
            $this->record->comment(body: $data['body'], author: $user);

            $this->dispatch('comment-created');

            $this->form->fill();
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }
    }
}

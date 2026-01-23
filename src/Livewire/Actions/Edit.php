<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Notifications\Notification;

trait Edit
{
    public bool $isEditing = false;

    public function openEdit()
    {
        if (! auth()->user()?->can('update', $this->comment)) {
            return;
        }

        $this->form->fill([
            'body' => $this->comment->body,
        ]);

        $this->isEditing = true;

        $this->js('document.body.click()');
    }

    public function cancelEdit()
    {
        $this->isEditing = false;

        $this->form->fill();
    }

    public function edit()
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if ($user && ! empty($data['body'])) {
            $this->comment->update([
                'body' => $data['body'],
            ]);

            $this->form->fill();

            $this->isEditing = false;

            $this->dispatch('comment-updated');
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }

        $this->isEditing = false;
    }
}

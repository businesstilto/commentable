<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Notifications\Notification;

trait Delete
{
    public function delete()
    {
        if (! auth()->user()?->can('delete', $this->comment)) {
            return;
        }

        $this->comment->delete();

        $this->dispatch('comment-deleted');

        Notification::make()
            ->title(__('commentable::translations.notifications.deleted'))
            ->success()
            ->send();
    }
}

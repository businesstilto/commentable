<?php

namespace Tilto\Commentable\Livewire;

use Filament\Notifications\Notification;
use Livewire\Component;

class Comment extends Component
{
    public $comment;

    public function render()
    {
        return view('commentable::livewire.comment');
    }

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

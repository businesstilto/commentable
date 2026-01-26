<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Tilto\Commentable\Livewire\CommentList;

trait Edit
{
    public bool $isEditing = false;

    public function editButton(): Action
    {
        return Action::make('edit')
            ->label(__('commentable::translations.dropdown.edit'))
            ->icon('heroicon-o-pencil-square')
            ->visible(fn () => auth()->user()?->can('update', $this->comment))
            ->authorize(fn () => auth()->user()?->can('update', $this->comment))
            ->action('openEdit');
    }

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

            $this->dispatch('comment-updated')->to(CommentList::class);
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }

        $this->isEditing = false;
    }
}

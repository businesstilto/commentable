<?php

namespace Tilto\Commentable\Livewire\Actions;

use Filament\Notifications\Notification;
use Filament\Actions\Action;

trait Delete
{
    public function deleteButton(): Action
    {
        return Action::make('delete')
            ->label(__('commentable::translations.dropdown.delete'))
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(__('commentable::translations.delete_confirmation.heading'))
            ->modalDescription(__('commentable::translations.delete_confirmation.description'))
            ->modalSubmitActionLabel(__('commentable::translations.delete_confirmation.confirm'))
            ->modalCancelActionLabel(__('commentable::translations.delete_confirmation.cancel'))
            ->visible(fn() => auth()->user()?->can('delete', $this->comment))
            ->action(function () {
                $this->comment->delete();

                $this->dispatch('comment-deleted');

                Notification::make()
                    ->title(__('commentable::translations.notifications.deleted'))
                    ->success()
                    ->send();
            });
    }
}

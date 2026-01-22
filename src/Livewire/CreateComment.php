<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Livewire\Component;
use Tilto\Commentable\Contracts\CommentableContract as Commentable;

class CreateComment extends Component implements HasForms
{
    use InteractsWithForms;

    public Commentable $record;

    public ?array $data = [];

    public string $buttonPosition = 'left';

    public bool $isMarkdownEditor = false;

    public array $toolbarButtons = [
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ];

    public function mount()
    {
        $this->form->fill([
            'body' => '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        if ($this->isMarkdownEditor) {
            return $schema
                ->schema([
                    MarkdownEditor::make('body')
                        ->hiddenLabel()
                        ->placeholder(__('commentable::translations.input_placeholder'))
                        ->toolbarButtons($this->toolbarButtons)
                        ->maxHeight(200)
                        ->required()
                        ->maxLength(65535),
                ])
                ->statePath('data');
        } else {
            return $schema
                ->schema([
                    RichEditor::make('body')
                        ->hiddenLabel()
                        ->placeholder(__('commentable::translations.input_placeholder'))
                        ->toolbarButtons($this->toolbarButtons)
                        ->required()
                        ->maxLength(65535),
                ])
                ->statePath('data');
        }
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && ! empty($data['body'])) {
            $this->record->comment($data['body'], $user);

            $this->dispatch('comment-created');

            $this->form->fill(['body' => '']);

            Notification::make()
                ->title(__('commentable::translations.notifications.created'))
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('commentable::livewire.create-comment');
    }
}

<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Livewire\Attributes\On;
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
    
    public function form(Schema $schema): Schema
    {
        if ($this->isMarkdownEditor) {
            return $schema
                ->schema([
                    MarkdownEditor::make('body')
                        ->hiddenLabel()
                        ->placeholder('Schrijf je reactie...')
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
                        ->placeholder('Schrijf je reactie...')
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

        $this->record->comment($data['body'], auth()->user());

        Notification::make()
            ->title('Reactie toegevoegd')
            ->success()
            ->send();

        $this->dispatch('comment:created');
    }

    public function render()
    {
        return view('commentable::livewire.create-comment');
    }

    #[On('comment:created')]
    #[On('comment:updated')]
    #[On('comment:deleted')]
    public function reload(): void
    {
        unset($this->comments);
    }
}

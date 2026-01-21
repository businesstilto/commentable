<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Livewire\Component;
use Filament\Notifications\Notification;
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

    public function mount(): void
    {
        $this->form->fill();
    }

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

        $data['author_type'] = get_class(auth()->user());
        $data['author_id'] = auth()->id();

        $data['commentable_type'] = get_class($this->record);
        $data['commentable_id'] = $this->record->getKey();

        $this->record->comments()->create($data);

        $this->form->fill();

        Notification::make()
            ->title('Reactie toegevoegd')
            ->success()
            ->send();

        $this->dispatch('comment-created');
    }

    public function render()
    {
        return view('commentable::livewire.create-comment');
    }
}

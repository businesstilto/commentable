<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Livewire\Component;
use Tilto\Commentable\Contracts\Commentable;
use Tilto\Commentable\Livewire\Actions\Delete;
use Tilto\Commentable\Livewire\Actions\Edit;
use Tilto\Commentable\Livewire\Actions\Reply;

class Comment extends Component implements HasForms
{
    use Edit;
    use Reply;
    use Delete;
    use InteractsWithForms;

    public Commentable $record;

    public $comment;

    public ?array $data = [];

    public string $buttonPosition = 'left';

    public bool $isMarkdownEditor = false;

    public ?string $fileAttachmentsDisk = null;

    public ?string $fileAttachmentsDirectory = null;

    public ?array $fileAttachmentsAcceptedFileTypes = null;

    public ?int $fileAttachmentsMaxSize = null;

    public bool $isNestable = false;

    public int $depth = 0;

    public array $toolbarButtons = [
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ];

    protected $listeners = [
        'comment-replied' => '$refresh',
    ];

    public function render()
    {
        if ($this->isNestable && $this->depth < 2) {
            $this->comment->loadMissing('replies.replies');
        }

        return view('commentable::livewire.comment');
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
                        ->required()
                        ->minHeight(200)
                        ->maxLength(65535)
                        ->fileAttachmentsDisk($this->fileAttachmentsDisk)
                        ->fileAttachmentsDirectory($this->fileAttachmentsDirectory)
                        ->fileAttachmentsAcceptedFileTypes($this->fileAttachmentsAcceptedFileTypes)
                        ->fileAttachmentsMaxSize($this->fileAttachmentsMaxSize),
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
                        ->maxLength(65535)
                        ->fileAttachmentsDisk($this->fileAttachmentsDisk)
                        ->fileAttachmentsDirectory($this->fileAttachmentsDirectory)
                        ->fileAttachmentsAcceptedFileTypes($this->fileAttachmentsAcceptedFileTypes)
                        ->fileAttachmentsMaxSize($this->fileAttachmentsMaxSize),
                ])
                ->statePath('data');
        }
    }
}

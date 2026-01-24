<?php

namespace Tilto\Commentable\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;
use Tilto\Commentable\Contracts\Commentable;
use Tilto\Commentable\Facades\CommentForm;
use Tilto\Commentable\Livewire\Actions\Delete;
use Tilto\Commentable\Livewire\Actions\Edit;
use Tilto\Commentable\Livewire\Actions\Reply;

class Comment extends Component implements HasActions, HasSchemas
{
    use Delete;
    use Edit;
    use Reply;
    use InteractsWithActions;
    use InteractsWithSchemas;

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
        'comment-deleted' => '$refresh',
    ];

    public function render()
    {
        if ($this->isNestable && $this->depth < 2) {
            $this->comment->loadMissing('replies.replies');
        }

        return view('commentable::livewire.comment');
    }

    public function cancel()
    {
        $this->dispatch('close-modal', id: 'delete-comment');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema(CommentForm::make($this))
            ->statePath('data');
    }
}

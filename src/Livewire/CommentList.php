<?php

namespace Tilto\Commentable\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Tilto\Commentable\Contracts\Commentable;

class CommentList extends Component
{
    public Model $record;

    public string $buttonPosition = 'left';

    public bool $isMarkdownEditor = false;

    public bool $resizableImages = false;

    public bool $shouldShowCommentCount = true;

    public ?string $fileAttachmentsDisk = null;

    public ?string $fileAttachmentsDirectory = null;

    public ?array $fileAttachmentsAcceptedFileTypes = null;

    public ?int $fileAttachmentsMaxSize = null;

    public bool $shouldPoll = false;

    public ?string $pollingInterval = null;

    public bool $isNestable = false;

    public bool $enableMentions = false;

    public array $toolbarButtons = [
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ];

    protected $listeners = [
        'comment-created' => '$refresh',
        'comment-updated' => '$refresh',
        'comment-deleted' => '$refresh',
    ];

    public function render()
    {
        return view('commentable::livewire.comment-list');
    }
}

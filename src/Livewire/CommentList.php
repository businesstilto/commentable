<?php

namespace Tilto\Commentable\Livewire;

use Livewire\Component;

class CommentList extends Component
{
    public $record;

    protected $listeners = [
        'comment-deleted' => '$refresh',
        'comment-created' => '$refresh',
    ];

    public function render()
    {
        return view('commentable::livewire.comment-list');
    }
}

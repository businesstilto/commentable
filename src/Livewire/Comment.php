<?php

namespace Tilto\Commentable\Livewire;

use Livewire\Component;

class Comment extends Component
{
    public $comment;
    
    public function render()
    {
        return view('commentable::livewire.comment');
    }
}

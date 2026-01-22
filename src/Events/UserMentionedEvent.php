<?php

namespace Tilto\Commentable\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Tilto\Commentable\Contracts\Commenter;
use Tilto\Commentable\Models\Comment;

class UserMentionedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public readonly Comment $comment;

    public readonly Commenter $user;

    public function __construct($comment, $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }
}

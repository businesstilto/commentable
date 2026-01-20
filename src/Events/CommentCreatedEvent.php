<?php

namespace Tilto\Commentable\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Tilto\Commentable\Models\Comment;

class CommentCreatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Comment $comment,
    ) {}
}

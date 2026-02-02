<?php

namespace Tilto\Commentable\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Tilto\Commentable\Models\Comment;
use Tilto\Commentable\Models\CommentReaction;

class CommentReactionEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Comment $comment,
        public CommentReaction $reaction,
        public string $action, // 'added' or 'removed'
    ) {}
}
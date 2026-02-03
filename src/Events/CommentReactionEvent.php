<?php

namespace Tilto\Commentable\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentReactionEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public mixed $comment,
        public mixed $reaction,
        public string $action, // 'added' or 'removed'
    ) {}
}

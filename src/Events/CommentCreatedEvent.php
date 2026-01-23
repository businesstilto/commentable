<?php

namespace Tilto\Commentable\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentCreatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public $comment,
    ) {}
}

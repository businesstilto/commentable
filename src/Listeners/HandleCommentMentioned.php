<?php

namespace Tilto\Commentable\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Tilto\Commentable\Events\UserMentionedEvent;

class HandleCommentMentioned implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserMentionedEvent $event): void
    {
        // ...
    }
}

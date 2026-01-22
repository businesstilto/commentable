<?php

namespace Tilto\Commentable\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Tilto\Commentable\Events\CommentCreatedEvent;

class HandleCommentCreated implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CommentCreatedEvent $event): void
    {
        $user = $event->comment->user;

        if (! config('commentable.events.comment_created_enabled', true)) {
            return;
        }

        $config = config('commentable.notifications.created');

        if (! ($config['enabled'] ?? false)) {
            return;
        }

        $channels = (array) ($config['channels'] ?? []);
        if ($channels === []) {
            return;
        }

        $notificationClass = $config['notification'] ?? null;

        if (! $notificationClass || ! class_exists($notificationClass)) {
            return;
        }

        $notification = app($notificationClass, [
            'comment' => $event->comment,
            'channels' => $channels,
        ]);

        Notification::send($user, $notification);
    }
}

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Comment model
    |--------------------------------------------------------------------------
    */
    'comment' => [
        'model' => Tilto\Commentable\Models\Comment::class,
        'policy' => Tilto\Commentable\Policies\CommentPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */
    'events' => [
        'comment_created' => [
            'enabled' => true,
            'event' => Tilto\Commentable\Events\CommentCreatedEvent::class,
            'listener' => Tilto\Commentable\Listeners\HandleCommentCreated::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'created' => [
            'enabled' => false,
            'channels' => ['database'],
        ],
        'mentions' => [
            'enabled' => true,
            'channels' => ['database'],
        ],
    ],
];

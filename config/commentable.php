<?php

return [

    'commenter' => [
        'model' => '',
    ],

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
        'comment_created_enabled' => true,
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

    /*
    |--------------------------------------------------------------------------
    | Event Listeners
    |--------------------------------------------------------------------------
    */
    'listeners' => [
        'comment_created' => Tilto\Commentable\Listeners\HandleCommentCreated::class,
        'comment_mentioned' => Tilto\Commentable\Listeners\HandleCommentMentioned::class,
    ],
];

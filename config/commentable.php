<?php

use Tilto\Commentable\Models\Comment;
use Tilto\Commentable\Models\CommentReaction;
use Tilto\Commentable\Policies\CommentPolicy;

return [
    /*
    |--------------------------------------------------------------------------
    | Comment model
    |--------------------------------------------------------------------------
    */
    'comment' => [
        'model' => Comment::class,
        'policy' => CommentPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Reply
    |--------------------------------------------------------------------------
    */
    'reply' => [
        'allow_self_reply' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Reaction
    |--------------------------------------------------------------------------
    */
    'reaction' => [
        'model' => CommentReaction::class,
        'allowed' => ['👍', '❤️', '😂', '😮', '😢', '🤔'],
    ],
];

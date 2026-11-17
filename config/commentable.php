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
    | Editor
    |--------------------------------------------------------------------------
    |
    | 'submit_shortcut' controls the keyboard shortcut for submitting a comment:
    | - 'mod+enter': Ctrl + Enter (Windows/Linux) or Cmd + Enter (macOS)
    | - 'enter': Enter submits, Shift + Enter inserts a new line
    | - false: no keyboard shortcut
    |
    */
    'editor' => [
        'submit_shortcut' => 'mod+enter',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reaction
    |--------------------------------------------------------------------------
    */
    'reaction' => [
        'model' => CommentReaction::class,
        'allowed' => ['👍', '❤️', '😂', '😮', '😢', '🤔'],
        'show_reactors_tooltip' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Date format
    |--------------------------------------------------------------------------
    |
    | The date format used to display comment timestamps.
    | Set to null to use Carbon's diffForHumans() method.
    | Otherwise, provide a valid Carbon date format.
    |
    | Examples:
    | - null        : 2 hours ago (default)
    | - 'd/m/Y'     : 12/11/2026
    | - 'd/m/Y H:i': 12/11/2026 15:30
    | - 'j F Y'     : 12 novembre 2026
    |
    */
    'date_format' => null,
];

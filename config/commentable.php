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
];

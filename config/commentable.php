<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Commenter model configuration
    |--------------------------------------------------------------------------
    */
    'commenter' => [
        'model' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Comment model configuration
    |--------------------------------------------------------------------------
    */
    'comment' => [
        'model' => Tilto\Commentable\Models\Comment::class,
        'policy' => Tilto\Commentable\Policies\CommentPolicy::class,
    ],
];

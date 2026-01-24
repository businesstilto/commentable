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
];

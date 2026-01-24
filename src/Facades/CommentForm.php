<?php

namespace Tilto\Commentable\Facades;

use Illuminate\Support\Facades\Facade;

class CommentForm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tilto\Commentable\Forms\CommentForm::class;
    }
}

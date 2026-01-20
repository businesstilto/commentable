<?php

namespace Tilto\Commentable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tilto\Commentable\Commentable
 */
class Commentable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tilto\Commentable\Commentable::class;
    }
}

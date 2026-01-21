<?php

namespace Tilto\Commentable\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface CommentableContract
{
    public function comments(): MorphMany;

    /**
     * Get the identifier key for the object. Usually the primary key.
     *
     * @return int|string|null
     */
    public function getKey();

    /**
     * @return string
     */
    public function getMorphClass();
}

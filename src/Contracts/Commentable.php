<?php

namespace Tilto\Commentable\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Commentable
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

    /**
     * Get mention providers for comments
     *
     * @return array|null
     */
    public function getCommentMentionProviders(): ?array;
}

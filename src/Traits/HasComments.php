<?php

namespace Tilto\Commentable\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tilto\Commentable\Models\Comment;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->latest()
            ->with('author');
    }
}

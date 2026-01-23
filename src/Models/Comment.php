<?php

namespace Tilto\Commentable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tilto\Commentable\Contracts\Commenter;

class Comment extends Model
{
    protected $fillable = [
        'parent_id',
        'body',
        'author_type',
        'author_id',
    ];

    public function author(): MorphTo
    {
        return $this->morphTo();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isAuthor(Commenter $author)
    {
        return $this->author_id === $author->getKey()
            && $this->author_type === get_class($author);
    }
}

<?php

namespace Tilto\Commentable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(config('commentable.comment.model'), 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(config('commentable.comment.model'), 'parent_id')
            ->with(['replies', 'author'])
            ->orderBy('created_at', 'asc');
    }

    public function isAuthor(Commenter $author)
    {
        return $this->author_id === $author->getKey()
            && $this->author_type === get_class($author);
    }

    public function getDepth(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }
}

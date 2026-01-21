<?php

namespace Tilto\Commentable\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Tilto\Commentable\Actions\SaveComment;
use Tilto\Commentable\Contracts\CommenterContract as Commenter;
use Tilto\Commentable\Models\Comment;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commentsQuery(): MorphMany
    {
        return $this->comments()
            ->latest()
            ->with(['author']);
    }

    public function comment(string $body, ?Commenter $author): Comment
    {
        return SaveComment::run($this, $author, $body);
    }

    public function getComments(?int $limit = null): Collection
    {
        if ($limit) {
            return $this->commentsQuery()->limit($limit)->get();
        }

        return $this->commentsQuery()->get();
    }
}

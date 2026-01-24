<?php

namespace Tilto\Commentable\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tilto\Commentable\Actions\SaveComment;
use Tilto\Commentable\Contracts\Commenter;
use Tilto\Commentable\Models\Comment;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(config('commentable.comment.model'), 'commentable')
            ->with('author')
            ->orderBy('created_at', 'asc');
    }

    public function comment(string $body, ?Commenter $author, ?int $parent_id = null): Comment
    {
        return SaveComment::run($this, $author, $body, $parent_id);
    }

    public function getCommentMentionProviders(): ?array
    {
        return null;
    }

    public function getRenderMentionProviders(): ?array
    {
        return null;
    }
}

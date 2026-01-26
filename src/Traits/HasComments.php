<?php

namespace Tilto\Commentable\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tilto\Commentable\Contracts\Commenter;
use Tilto\Commentable\Events\CommentCreatedEvent;
use Tilto\Commentable\Models\Comment;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(config('commentable.comment.model'), 'commentable')
            ->with('author')
            ->orderBy('created_at', 'asc');
    }

    public function comment(Model $commentable, ?int $parent_id, string $body, Commenter $author): Comment
    {
        $commentModel = config('commentable.comment.model');

        if ($author->cannot('create', $commentModel)) {
            throw new AuthorizationException('Cannot create comment');
        }

        $comment = $commentable->comments()->create([
            'parent_id' => $parent_id ? $parent_id : null,
            'body' => $body,
            'author_id' => $author->getKey(),
            'author_type' => $author->getMorphClass(),
        ]);

        CommentCreatedEvent::dispatch($comment);

        return $comment;
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

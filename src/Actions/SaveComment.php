<?php

namespace Tilto\Commentable\Actions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Tilto\Commentable\Contracts\CommenterContract as Commenter;
use Tilto\Commentable\Events\CommentCreatedEvent;
use Tilto\Commentable\Models\Comment;

class SaveComment
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Model $commentable, Commenter $author, string $body): Comment
    {
        if ($author->cannot('create', Comment::class)) {
            throw new AuthorizationException('Cannot create comment');
        }

        $comment = $commentable->comments()->create([
            'body' => $body,
            'author_id' => $author->getKey(),
            'author_type' => $author->getMorphClass(),
        ]);

        event(new CommentCreatedEvent($comment));

        return $comment;
    }

    public static function run(...$args)
    {
        return (new static)(...$args);
    }
}

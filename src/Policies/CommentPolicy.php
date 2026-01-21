<?php

namespace Tilto\Commentable\Policies;

use Tilto\Commentable\Contracts\CommenterContract;
use Tilto\Commentable\Models\Comment;

class CommentPolicy
{
    public function create(CommenterContract $user): bool
    {
        return true;
    }

    public function update(CommenterContract $user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }

    public function delete(CommenterContract $user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }
}

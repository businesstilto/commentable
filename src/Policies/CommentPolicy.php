<?php

namespace Tilto\Commentable\Policies;

use Tilto\Commentable\Contracts\CommenterContract as Commenter;
use Tilto\Commentable\Models\Comment;

class CommentPolicy
{
    public function create(Commenter $user): bool
    {
        return true;
    }

    public function update($user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }

    public function delete($user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }
}

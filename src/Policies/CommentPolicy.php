<?php

namespace Tilto\Commentable\Policies;

use Tilto\Commentable\Contracts\Commenter;
use Tilto\Commentable\Models\Comment;

class CommentPolicy
{
    public function create(Commenter $user): bool
    {
        return true;
    }

    public function update(Commenter $user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }

    public function reply(Commenter $user, Comment $comment): bool
    {
        return true;
    }

    public function react(Commenter $user, Comment $comment): bool
    {
        return true;
    }

    public function delete(Commenter $user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }
}

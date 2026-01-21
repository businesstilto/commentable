<?php

namespace Tilto\Commentable\Traits;

trait IsCommenter
{
    public function getCommenterName(): string
    {
        return $this->name;
    }

    public function getCommenterAvatar(): string
    {
        $avatar = null;

        if ($this->author instanceof HasAvatar) {
            $avatar = $this->author->getFilamentAvatarUrl();
        }

        if (!is_null($avatar)) {
            return $avatar;
        }

        $name = str($this->getCommenterName())
            ->trim()
            ->explode(' ')
            ->map(fn(string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
            ->join(' ');

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=71717b';
    }
}

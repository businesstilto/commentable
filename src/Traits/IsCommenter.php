<?php

namespace Tilto\Commentable\Traits;

use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

trait IsCommenter
{
    public function getCommenterName(): string
    {
        return $this->name;
    }

    public function getCommenterAvatar(): ?string
    {
        if ($this instanceof Model && $this instanceof Authenticatable) {
            return Filament::getUserAvatarUrl($this);
        }

        $name = str($this->getCommenterName())
            ->trim()
            ->explode(' ')
            ->map(fn (string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
            ->join(' ');

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=71717b';
    }
}

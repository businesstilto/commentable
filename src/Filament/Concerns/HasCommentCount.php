<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasCommentCount
{
    protected bool $shouldShowCommentCount = true;

    public function hideCommentCount(): static
    {
        $this->shouldShowCommentCount = false;

        return $this;
    }

    public function shouldShowCommentCount(): bool
    {
        return $this->shouldShowCommentCount;
    }
}

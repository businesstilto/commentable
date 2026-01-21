<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasReplies
{
    protected bool $nestable = false;

    public function nestable(bool $condition = true): static
    {
        $this->nestable = $condition;

        return $this;
    }

    public function isNestable(): bool
    {
        return $this->nestable;
    }
}

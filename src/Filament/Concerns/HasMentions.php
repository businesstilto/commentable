<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasMentions
{
    protected bool $enableMentions = false;

    public function mentions(bool $enable = true): static
    {
        $this->enableMentions = $enable;

        return $this;
    }

    public function getMentionsEnabled(): bool
    {
        return $this->enableMentions;
    }
}

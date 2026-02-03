<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasReactions
{
    protected bool $reactionsEnabled = true;

    protected array $allowedReactions = [];

    public function reactions(bool $enabled = true): static
    {
        $this->reactionsEnabled = $enabled;

        return $this;
    }

    public function allowedReactions(array $reactions): static
    {
        $this->allowedReactions = $reactions;

        return $this;
    }

    public function disableReactions(): static
    {
        $this->reactionsEnabled = false;

        return $this;
    }

    public function getReactionsEnabled(): bool
    {
        return $this->reactionsEnabled;
    }

    public function getAllowedReactions(): array
    {
        return empty($this->allowedReactions)
            ? config('commentable.reaction.allowed', [])
            : $this->allowedReactions;
    }
}

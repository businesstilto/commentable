<?php

namespace Tilto\Commentable\Filament\Concerns;

use Closure;

trait HasMentions
{
    protected array | Closure | null $mentions = null;

    public function mentions(array | Closure | null $providers): static
    {
        $this->mentions = $providers;

        return $this;
    }

    public function getMentions()
    {
        return $this->evaluate($this->mentions);
    }
}

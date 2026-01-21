<?php

namespace Tilto\Commentable\Filament\Concerns;

use Closure;
use Illuminate\Support\Collection;

trait HasMentionables
{
    protected array|Collection|Closure|null $mentionables = null;

    public function mentionables(array|Collection|Closure $mentionables): static
    {
        $this->mentionables = $mentionables;

        return $this;
    }

    public function getMentionables()
    {
        return $this->evaluate($this->mentionables);
    }
}

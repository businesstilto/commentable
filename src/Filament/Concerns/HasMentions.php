<?php

namespace Tilto\Commentable\Filament\Concerns;

use Closure;
use Illuminate\Support\Collection;

trait HasMentions
{
    protected array | Collection | Closure | null $mentions = null;

    public function mentions(array | Collection | Closure $mentions): static
    {
        $this->mentions = $mentions;

        return $this;
    }

    public function getMentions()
    {
        return $this->evaluate($this->mentions);
    }
}

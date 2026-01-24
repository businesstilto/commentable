<?php

namespace Tilto\Commentable\Filament\Concerns;

use Closure;
use Tilto\Commentable\Support\MentionProviderRegistry;

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

    public function getMentionsConfig(): ?string
    {
        $mentions = $this->mentions;

        if (! $mentions) {
            return null;
        }

        if ($mentions instanceof Closure) {
            $mentions = $this->evaluate($mentions);
        }

        $key = 'mentions_' . static::class;

        MentionProviderRegistry::register($key, $mentions);

        return $key;
    }
}

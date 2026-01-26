<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasPolling
{
    protected bool $enablePolling = false;

    protected ?string $pollInterval = null;

    public function enablePolling(bool $condition = true): static
    {
        $this->enablePolling = $condition;

        if ($condition) {
            $this->pollInterval = null;
        }

        return $this;
    }

    public function pollInterval(string $interval): static
    {
        $this->enablePolling = true;
        $this->pollInterval = $interval;

        return $this;
    }

    public function shouldPoll(): bool
    {
        return $this->enablePolling;
    }

    public function getPollInterval(): ?string
    {
        return $this->pollInterval;
    }
}

<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasPolling
{
    protected bool $enablePolling = false;

    protected ?string $pollingInterval = null;

    public function enablePolling(bool $condition = true): static
    {
        $this->enablePolling = $condition;

        if ($condition) {
            $this->pollingInterval = null;
        }

        return $this;
    }

    public function pollingInterval(string $interval): static
    {
        $this->enablePolling = true;
        $this->pollingInterval = $interval;

        return $this;
    }

    public function shouldPoll(): bool
    {
        return $this->enablePolling;
    }

    public function getPollingInterval(): ?string
    {
        return $this->pollingInterval;
    }
}

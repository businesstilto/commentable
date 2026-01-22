<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasPolling
{
    protected bool $enablePolling = false;

    /**
     * Enable standard wire:poll
     */
    public function enablePolling(bool $condition = true): static
    {
        $this->enablePolling = $condition;

        // Standard poll = no interval
        if ($condition) {
            $this->pollingInterval = null;
        }

        return $this;
    }

    /**
     * Enable wire:poll.{interval}
     */
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

    /**
     * Filament expects:
     * - null  → wire:poll
     * - string → wire:poll.{interval}
     */
    public function getPollingInterval(): ?string
    {
        return $this->pollingInterval;
    }
}

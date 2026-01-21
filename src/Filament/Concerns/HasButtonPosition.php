<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasButtonPosition
{
    protected string $buttonPosition = 'left';

    public function buttonPosition(string $position): static
    {
        $this->buttonPosition = $position;

        return $this;
    }

    public function getButtonPosition(): string
    {
        return $this->buttonPosition;
    }
}

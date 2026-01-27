<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasEditor
{
    protected array|null $toolbarButtons = null;

    public function toolbarButtons(array $buttons): static
    {
        $this->toolbarButtons = $buttons;

        return $this;
    }

    public function getToolbarButtons(): ?array
    {
        return $this->toolbarButtons;
    }
}

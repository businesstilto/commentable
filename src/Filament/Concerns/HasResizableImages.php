<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasResizableImages
{
    protected bool $resizableImages = false;

    public function resizableImages(bool $resizable = true): static
    {
        $this->resizableImages = $resizable;

        return $this;
    }

    public function getResizableImagesEnabled(): bool
    {
        return $this->resizableImages;
    }
}

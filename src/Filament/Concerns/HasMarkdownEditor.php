<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasMarkdownEditor {
    protected bool $isMarkdownEditor = false;

    public function markdownEditor(bool $condition = true): static
    {
        $this->isMarkdownEditor = $condition;

        return $this;
    }

    public function isMarkdownEditor(): bool
    {
        return $this->isMarkdownEditor;
    }
}

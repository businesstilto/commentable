<?php

namespace Tilto\Commentable\Forms;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;

class CommentForm
{
    public function editor($component): \Filament\Forms\Components\Field
    {
        $editor = $component->isMarkdownEditor
            ? MarkdownEditor::make('body')->minHeight(200)
            : RichEditor::make('body');

        $editor
            ->hiddenLabel()
            ->placeholder(__('commentable::translations.input_placeholder'))
            ->required()
            ->maxLength(65535);

        if ($component->toolbarButtons ?? null) {
            $editor->toolbarButtons($component->toolbarButtons);
        }

        if ($component->fileAttachmentsDisk) {
            $editor->fileAttachmentsDisk($component->fileAttachmentsDisk);
        }

        if ($component->fileAttachmentsDirectory) {
            $editor->fileAttachmentsDirectory($component->fileAttachmentsDirectory);
        }

        if ($component->fileAttachmentsAcceptedFileTypes) {
            $editor->fileAttachmentsAcceptedFileTypes($component->fileAttachmentsAcceptedFileTypes);
        }

        if ($component->fileAttachmentsMaxSize) {
            $editor->fileAttachmentsMaxSize($component->fileAttachmentsMaxSize);
        }

        return $editor;
    }

    public function make($component): array
    {
        return [
            $this->editor($component),
        ];
    }
}

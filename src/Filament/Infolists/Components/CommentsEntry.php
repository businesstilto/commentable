<?php

namespace Tilto\Commentable\Filament\Infolists\Components;

use Filament\Infolists\Components\Entry;
use Tilto\Commentable\Filament\Concerns\HasAttachments;
use Tilto\Commentable\Filament\Concerns\HasButtonPosition;
use Tilto\Commentable\Filament\Concerns\HasEditor;
use Tilto\Commentable\Filament\Concerns\HasMarkdownEditor;
use Tilto\Commentable\Filament\Concerns\HasMentionables;

class CommentsEntry extends Entry
{
    use HasAttachments;
    use HasButtonPosition;
    use HasEditor;
    use HasMarkdownEditor;
    use HasMentionables;

    protected string $view = 'commentable::filament.infolists.components.comments-entry';
}

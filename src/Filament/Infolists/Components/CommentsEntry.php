<?php

namespace Tilto\Commentable\Filament\Infolists\Components;

use Filament\Infolists\Components\Entry;
use Tilto\Commentable\Filament\Concerns\HasAttachments;
use Tilto\Commentable\Filament\Concerns\HasButtonPosition;
use Tilto\Commentable\Filament\Concerns\HasCommentCount;
use Tilto\Commentable\Filament\Concerns\HasEditor;
use Tilto\Commentable\Filament\Concerns\HasMarkdownEditor;
use Tilto\Commentable\Filament\Concerns\HasMentions;
use Tilto\Commentable\Filament\Concerns\HasPolling;
use Tilto\Commentable\Filament\Concerns\HasReplies;
use Tilto\Commentable\Filament\Concerns\HasResizableImages;

class CommentsEntry extends Entry
{
    use HasAttachments;
    use HasButtonPosition;
    use HasCommentCount;
    use HasEditor;
    use HasMarkdownEditor;
    use HasMentions;
    use HasPolling;
    use HasReplies;
    use HasResizableImages;

    protected string $view = 'commentable::filament.infolists.components.comments-entry';
}

<?php

namespace Tilto\Commentable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tilto\Commentable\Contracts\Commenter;

/**
 * @property-read Comment $comment
 * @property-read Commenter $reactor
 */
class CommentReaction extends Model
{
    protected $fillable = [
        'comment_id',
        'reactor_id',
        'reactor_type',
        'reaction',
    ];

    /** @return BelongsTo<Comment> */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(config('commentable.comment.model'));
    }

    /** @return MorphTo<Commenter> */
    public function reactor(): MorphTo
    {
        return $this->morphTo();
    }
}

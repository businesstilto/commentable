<?php

namespace Tilto\Commentable\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Tilto\Commentable\Models\Comment;

class CommentReactions extends Component
{
    public Comment $comment;

    public function toggleReaction(string $reaction): void
    {
        $this->comment->toggleReaction($reaction);

        $this->dispatch('$refresh')->self();
    }

    public function render(): View
    {
        return view('commentable::livewire.comment-reactions', [
            'allowedReactions' => config('commentable.reaction.allowed', []),
        ]);
    }

    #[Computed]
    public function reactionSummary()
    {
        if (! $this->comment->relationLoaded('reactions')) {
            $this->comment->load('reactions.reactor');
        }

        $user = auth()->user();

        return $this->comment->reactions
            ->groupBy('reaction')
            ->map(function ($group) use ($user) {
                return [
                    'count' => $group->count(),
                    'reaction' => $group->first()->reaction,
                    'reacted_by_current_user' => $user && $group->contains(
                        fn ($reaction) => $reaction->reactor_id == $user->getKey() &&
                        $reaction->reactor_type == $user->getMorphClass()
                    ),
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->toArray();
    }
}

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

        $showReactorsTooltip = config('commentable.reaction.show_reactors_tooltip', true);

        return $this->comment->reactions
            ->groupBy('reaction')
            ->map(function ($group) use ($user, $showReactorsTooltip) {
                $reactedByCurrentUser = $user && $group->contains(
                    fn ($reaction) => $reaction->reactor_id == $user->getKey() &&
                    $reaction->reactor_type == $user->getMorphClass()
                );

                return [
                    'count' => $group->count(),
                    'reaction' => $group->first()->reaction,
                    'reacted_by_current_user' => $reactedByCurrentUser,
                    'tooltip' => $showReactorsTooltip
                        ? $this->reactorsTooltip($group, $reactedByCurrentUser, $user)
                        : null,
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->toArray();
    }

    protected function reactorsTooltip($group, bool $reactedByCurrentUser, $user): string
    {
        $emoji = $group->first()->reaction;

        $names = collect();

        if ($reactedByCurrentUser) {
            $names->push(__('commentable::translations.reactions.you'));
        }

        foreach ($group as $reaction) {
            $isCurrentUser = $user &&
                $reaction->reactor_id == $user->getKey() &&
                $reaction->reactor_type == $user->getMorphClass();

            if ($isCurrentUser) {
                continue;
            }

            $names->push($reaction->reactor?->getCommenterName()
                ?? __('commentable::translations.reactions.unknown_user'));
        }

        return match (true) {
            $names->count() === 1 && $reactedByCurrentUser => __('commentable::translations.reactions.reacted_by_you', ['emoji' => $emoji]),
            $names->count() === 1 => __('commentable::translations.reactions.reacted_by_one', ['user' => $names->first(), 'emoji' => $emoji]),
            default => __('commentable::translations.reactions.reacted_by_many', [
                'users' => $names->join(', ', __('commentable::translations.reactions.and')),
                'emoji' => $emoji,
            ]),
        };
    }
}

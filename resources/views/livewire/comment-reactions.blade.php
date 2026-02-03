<div class="fi-commentable fi-comment-reactions">
    {{-- Inline buttons for existing reactions --}}
    @foreach ($this->reactionSummary as $reactionData)
        <span wire:key="inline-reaction-button-{{ $reactionData['reaction'] }}-{{ $comment->id }}">
            <button wire:click="toggleReaction('{{ $reactionData['reaction'] }}')" type="button"
                class="fi-comment-reaction-button {{ $reactionData['reacted_by_current_user'] ? 'fi-comment-reaction-button--reacted' : 'fi-comment-reaction-button--not-reacted' }}"
                title="{{ $reactionData['reaction'] }}">
                <span>{{ $reactionData['reaction'] }}</span>
                <span
                    wire:key="inline-reaction-count-{{ $reactionData['reaction'] }}-{{ $comment->id }}">{{ $reactionData['count'] }}</span>
            </button>
        </span>
    @endforeach

    {{-- Add Reaction Button --}}
    <div class="relative" x-data="{ open: false }" wire:ignore.self>
        <button x-on:click="open = !open" type="button" @disabled(!auth()->check())
            class="fi-comment-add-reaction-button" title="{{ __('commentable::translations.add_reaction') }}"
            wire:key="add-reaction-button-{{ $comment->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>

        {{-- Reaction Popup --}}
        <div x-show="open" x-cloak x-on:click.away="open = false" class="fi-comment-reaction-popup"
            :class="{ 'hidden': !open, 'flex': open }">
            @foreach ($allowedReactions as $reactionEmoji)
                @php
                    $reactionData = collect($this->reactionSummary)->firstWhere('reaction', $reactionEmoji) ?? [
                        'count' => 0,
                        'reacted_by_current_user' => false,
                    ];
                @endphp

                <button wire:click="toggleReaction('{{ $reactionEmoji }}')" x-on:click="open = false" type="button"
                    @disabled(!auth()->check())
                    class="fi-comment-reaction-popup-button {{ $reactionData['reacted_by_current_user'] ? 'fi-comment-reaction-popup-button--reacted' : '' }}"
                    title="{{ $reactionEmoji }}"
                    wire:key="popup-reaction-button-{{ $reactionEmoji }}-{{ $comment->id }}">
                    <span>{{ $reactionEmoji }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>

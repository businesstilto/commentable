@php
    $submitShortcut = config('commentable.editor.submit_shortcut', 'mod+enter');

    $shortcutAttributes = match ($submitShortcut) {
        'mod+enter' => 'x-on:keydown.ctrl.enter.capture.prevent.stop="$el.requestSubmit()" x-on:keydown.meta.enter.capture.prevent.stop="$el.requestSubmit()"',
        'enter' => 'x-on:keydown.enter.capture="if (! $event.shiftKey) { $event.preventDefault(); $event.stopPropagation(); $el.requestSubmit(); }"',
        default => '',
    };
@endphp
{!! $shortcutAttributes !!}

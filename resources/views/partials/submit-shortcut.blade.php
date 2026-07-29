@php
    $submitShortcut = config('commentable.editor.submit_shortcut', 'mod+enter');
@endphp

@if ($submitShortcut === 'mod+enter')
    x-on:keydown.ctrl.enter.capture.prevent.stop="$el.requestSubmit()"
    x-on:keydown.meta.enter.capture.prevent.stop="$el.requestSubmit()"
@elseif ($submitShortcut === 'enter')
    x-on:keydown.enter.capture="if (! $event.shiftKey) { $event.preventDefault(); $event.stopPropagation(); $el.requestSubmit(); }"
@endif

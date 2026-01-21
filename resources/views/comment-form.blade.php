@props(['form'])

<form wire:submit="create">
    {{ $form }}

    <button type="submit">
        Submit
    </button>
</form>

<?php

namespace Tilto\Commentable\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;
use Tilto\Commentable\Contracts\Commentable;
use Tilto\Commentable\Facades\CommentForm;

class CreateComment extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Commentable $record;

    public ?array $data = [];

    public string $buttonPosition = 'left';

    public bool $isMarkdownEditor = false;

    protected $mentions = null;

    public ?string $fileAttachmentsDisk = null;

    public ?string $fileAttachmentsDirectory = null;

    public ?array $fileAttachmentsAcceptedFileTypes = null;

    public ?int $fileAttachmentsMaxSize = null;

    public array $toolbarButtons = [
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ];

    public function mount($mentions = null): void
    {
        $this->mentions = $mentions;

        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        $editor = CommentForm::editor($this);

        if ($this->mentions) {
            $editor->mentions($this->mentions);
        }

        return $schema
            ->schema($editor)
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && !empty($data['body'])) {
            $this->record->comment(body: $data['body'], author: $user);

            $this->dispatch('comment-created');

            $this->form->fill();
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('commentable::livewire.create-comment');
    }
}

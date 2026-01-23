<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\RichEditor;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Livewire\Component;
use Tilto\Commentable\Contracts\Commentable;
use Filament\Forms\Components\MarkdownEditor;

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
        $editor = $this->isMarkdownEditor
            ? MarkdownEditor::make('body')->minHeight(200)
            : RichEditor::make('body');

        $editor
            ->hiddenLabel()
            ->placeholder(__('commentable::translations.input_placeholder'))
            ->required()
            ->maxLength(65535);

        if ($this->toolbarButtons ?? null) {
            $editor->toolbarButtons($this->toolbarButtons);
        }

        if ($this->fileAttachmentsDisk) {
            $editor->fileAttachmentsDisk($this->fileAttachmentsDisk);
        }

        if ($this->fileAttachmentsDirectory) {
            $editor->fileAttachmentsDirectory($this->fileAttachmentsDirectory);
        }

        if ($this->fileAttachmentsAcceptedFileTypes) {
            $editor->fileAttachmentsAcceptedFileTypes($this->fileAttachmentsAcceptedFileTypes);
        }

        if ($this->fileAttachmentsMaxSize) {
            $editor->fileAttachmentsMaxSize($this->fileAttachmentsMaxSize);
        }

        if (property_exists($this, 'mentions') && $this->mentions) {
            $editor->mentions($this->mentions);
        }

        return $schema
            ->schema([
                $editor,
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && ! empty($data['body'])) {
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

    protected function getMentionProviders()
    {
        // Convert arrays back to MentionProvider objects if needed
        if (! is_array($this->mentions)) {
            return [];
        }

        return array_map(function ($provider) {
            if (is_array($provider) && isset($provider['trigger'])) {
                // Rebuild MentionProvider from array (basic, extend as needed)
                return
                    \Filament\Forms\Components\RichEditor\MentionProvider::make($provider['trigger'])
                        ->items($provider['items'] ?? []);
            }

            return $provider;
        }, $this->mentions);
    }

    public function render()
    {
        return view('commentable::livewire.create-comment');
    }
}

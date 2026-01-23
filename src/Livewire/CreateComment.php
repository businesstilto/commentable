<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Livewire\Component;
use Tilto\Commentable\Contracts\Commentable;

class CreateComment extends Component implements HasForms
{
    use InteractsWithForms;

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

        $this->form->fill([
            'body' => '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        if ($this->isMarkdownEditor) {
            return $schema
                ->schema([
                    MarkdownEditor::make('body')
                        ->hiddenLabel()
                        ->placeholder(__('commentable::translations.input_placeholder'))
                        ->toolbarButtons($this->toolbarButtons)
                        ->required()
                        ->maxLength(65535)
                        ->fileAttachmentsDisk($this->fileAttachmentsDisk)
                        ->fileAttachmentsDirectory($this->fileAttachmentsDirectory)
                        ->fileAttachmentsAcceptedFileTypes($this->fileAttachmentsAcceptedFileTypes)
                        ->fileAttachmentsMaxSize($this->fileAttachmentsMaxSize),
                ])
                ->statePath('data');
        } else {
            return $schema
                ->schema([
                    RichEditor::make('body')
                        ->hiddenLabel()
                        ->placeholder(__('commentable::translations.input_placeholder'))
                        ->toolbarButtons($this->toolbarButtons)
                        ->required()
                        ->maxLength(65535)
                        ->mentions(fn () => $this->mentions ?? [])
                        ->fileAttachmentsDisk($this->fileAttachmentsDisk)
                        ->fileAttachmentsDirectory($this->fileAttachmentsDirectory)
                        ->fileAttachmentsAcceptedFileTypes($this->fileAttachmentsAcceptedFileTypes)
                        ->fileAttachmentsMaxSize($this->fileAttachmentsMaxSize),
                ])
                ->statePath('data');
        }
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if (method_exists($this->record, 'comment') && $user && ! empty($data['body'])) {
            $this->record->comment($data['body'], $user);

            $this->dispatch('comment-created');

            $this->form->fill(['body' => '']);
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

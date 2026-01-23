<?php

namespace Tilto\Commentable\Livewire;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Livewire\Component;

class Comment extends Component implements HasForms
{
    use InteractsWithForms;

    public $comment;

    public ?array $data = [];

    public string $buttonPosition = 'left';

    public bool $isMarkdownEditor = false;

    protected $mentions = null;

    public ?string $fileAttachmentsDisk = null;

    public ?string $fileAttachmentsDirectory = null;

    public ?array $fileAttachmentsAcceptedFileTypes = null;

    public ?int $fileAttachmentsMaxSize = null;

    public bool $isNestable = false;

    public bool $isEditing = false;

    public array $toolbarButtons = [
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ];

    public function render()
    {
        return view('commentable::livewire.comment');
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
                        ->maxHeight(200)
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

    public function cancel()
    {
        $this->isEditing = false;

        $this->form->fill([
            'body' => '',
        ]);
    }

    public function openEdit()
    {
        if (! auth()->user()?->can('update', $this->comment)) {
            return;
        }

        $this->form->fill([
            'body' => $this->comment->body,
        ]);

        $this->isEditing = true;

        $this->js('document.body.click()');
    }

    public function edit()
    {
        $data = $this->form->getState();

        $user = auth()->check() ? auth()->user() : null;

        if ($user && ! empty($data['body'])) {
            $this->comment->update([
                'body' => $data['body'],
            ]);

            $this->form->fill(['body' => '']);

            $this->isEditing = false;

            $this->dispatch('comment-updated');
        } else {
            Notification::make()
                ->title(__('commentable::translations.notifications.something_went_wrong'))
                ->danger()
                ->send();
        }

        $this->isEditing = false;
    }

    public function delete()
    {
        if (! auth()->user()?->can('delete', $this->comment)) {
            return;
        }

        $this->comment->delete();

        $this->dispatch('comment-deleted');

        Notification::make()
            ->title(__('commentable::translations.notifications.deleted'))
            ->success()
            ->send();
    }
}

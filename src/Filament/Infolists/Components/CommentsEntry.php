<?php

namespace Tilto\Commentable\Filament\Infolists\Components;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Entry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class CommentsEntry extends Entry implements HasSchemas
{
    use InteractsWithSchemas;

    protected array $toolbarActions = [];

    public function toolbarActions(array $actions): static
    {
        $this->toolbarActions = $actions;

        return $this;
    }

    public function getToolbarActions(): array
    {
        return $this->toolbarActions;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('data')
                    ->label('test')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    protected string $view = 'commentable::filament.infolists.components.comments-entry';
}

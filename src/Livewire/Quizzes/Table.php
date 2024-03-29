<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Quizzes;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class Table extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery(): Builder|Relation
    {
        return Quiz::query();
    }

    public function getTableColumns(): array
    {
        return [
            ImageColumn::make('featured_image')->disk('do'),
            TextColumn::make('name.en'),
            TextColumn::make('heading.en'),
            TextColumn::make('sub_heading.en'),
            TextColumn::make('question_duration'),
            TextColumn::make('starts_at'),
            TextColumn::make('ends_at'),
            IconColumn::make('active')->boolean(),
        ];
    }

    public function getTableActions(): array
    {
        return [
            EditAction::make()->url(fn($record) => route('hub.quiz-app.edit', $record)),
            DeleteAction::make()->requiresConfirmation(),
        ];
    }

    public function render()
    {
        return view('adminhub::livewire.components.tables.base-table')
            ->layout('adminhub::layouts.base');
    }
}

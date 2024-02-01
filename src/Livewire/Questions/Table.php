<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Questions;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;
use stdClass;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class Table extends Component implements HasTable
{
    use InteractsWithTable;

    public Quiz $quiz;

    public function getTableQuery(): Builder|Relation
    {
        return QuizQuestion::query()->where('quiz_id', $this->quiz->id);
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('number')->formatStateUsing(
                fn(stdClass $rowLoop, HasTable $livewire): string => (string) ($rowLoop->iteration + ($livewire->tableRecordsPerPage * ($livewire->page - 1))
            )),
            TextColumn::make('name.en')->label('Question'),
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

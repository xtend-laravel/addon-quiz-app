<?php

namespace XtendLunar\Addons\QuizApp\Livewire\PrizeTiers;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;

class Table extends Component implements HasTable
{
    use InteractsWithTable;

    public Quiz $quiz;

    public function getTableQuery(): Builder|Relation
    {
        return QuizPrizeTier::query()->where('quiz_id', $this->quiz->id);
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name.en')->label('Tier Name'),
            TextColumn::make('discount')->getStateUsing(fn(QuizPrizeTier $record) => 'DISCOUNT24'),
            BadgeColumn::make('percentage_off')->getStateUsing(fn(QuizPrizeTier $record) => $value ?? 100 . '%'),
        ];
    }

    public function getTableActions(): array
    {
        return [
            EditAction::make()->url(fn($record) => route('hub.quiz-app.edit-prize-tier', ['quiz' => $this->quiz, 'prizeTier' => $record])),
            DeleteAction::make()->requiresConfirmation(),
        ];
    }

    public function render()
    {
        return view('adminhub::livewire.components.tables.base-table')
            ->layout('adminhub::layouts.base');
    }
}

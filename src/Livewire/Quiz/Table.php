<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Quiz;

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

        ];
    }

    protected function getTableFilters(): array
    {
        return [

        ];
    }

    public function render()
    {
        return view('adminhub::livewire.components.tables.base-table')
            ->layout('adminhub::layouts.base');
    }
}

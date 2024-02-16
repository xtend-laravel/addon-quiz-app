<?php

namespace XtendLunar\Addons\QuizApp\Livewire\PrizeTiers;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use XtendLunar\Addons\PageBuilder\Fields\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Lunar\Hub\Http\Livewire\Traits\Notifies;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;

class Form extends Component implements HasForms
{
    use InteractsWithForms;
    use Notifies;

    public Quiz $quiz;

    public ?QuizPrizeTier $prizeTier = null;

    public function mount(): void
    {
        $state = $this->prizeTier ? [
            'name' => $this->prizeTier->name ?? null,
        ] : [];

        $this->form->fill($state);
    }

    protected function getFormModel(): QuizPrizeTier
    {
        return $this->prizeTier ?? new QuizPrizeTier();
    }

    public function getFormSchema(): array
    {
        return [
            Card::make()->columns(3)->schema([
                TextInput::make('name')
                    ->required()
                    ->translatable(),
                TextInput::make('percentage_off')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100),
                Select::make('discount')
                    ->relationship('discount', 'name'),
            ]),
        ];
    }

    public function submit()
    {
        $this->prizeTier ? $this->update() : $this->create();

        $this->redirect(route('hub.quiz-app.edit', $this->quiz));
    }

    public function create(): void
    {
        /** @var \XtendLunar\Addons\QuizApp\Models\QuizPrizeTier $prizeTier */
        $prizeTier = $this->quiz->prizeTiers()->create($this->form->getState());

        $this->notify($prizeTier->translate('name').' quiz created');
    }

    public function update(): void
    {
        $this->prizeTier->update($this->form->getState());

        $this->notify($this->prizeTier->translate('name').' quiz updated');
    }

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.components.edit-form')
            ->layout('adminhub::layouts.app');
    }
}

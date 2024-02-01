<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Questions;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Lunar\Models\Language;
use XtendLunar\Addons\PageBuilder\Fields\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Lunar\Hub\Http\Livewire\Traits\Notifies;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizAnswer;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class Form extends Component implements HasForms
{
    use InteractsWithForms;
    use Notifies;

    public Quiz $quiz;

    public ?QuizQuestion $question = null;

    public $answers;

    public function mount(): void
    {
        $state = $this->question ? [
            'name' => $this->question->name,
            'answers' => $this->question->answers->map(fn(QuizAnswer $answer) => [
                ...Language::all()->mapWithKeys(fn(Language $language) => [
                    'name.' . $language->code => $answer?->translate('name', $language->code),
                ])->toArray(),
                'is_correct' => $answer->is_correct,
            ])->toArray(),
        ] : [];

        $this->form->fill($state);
    }

    protected function getFormModel(): QuizQuestion
    {
        return $this->question->loadMissing('answers') ?? new QuizQuestion();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->translatable(),
            Repeater::make('answers')
                ->relationship()
                ->schema([
                    TextInput::make('name')->translatable(),
                    Toggle::make('is_correct'),
                ])
                ->grid(4)
                ->defaultItems(4)
                ->disableItemCreation()
                ->disableItemDeletion(),
        ];
    }

    public function submit()
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.components.edit-form')
            ->layout('adminhub::layouts.app');
    }
}

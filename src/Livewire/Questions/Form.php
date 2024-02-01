<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Questions;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Collection;
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

    public function mount(): void
    {
        $state = $this->question ? [
            'name' => $this->question->name,
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
                ->saveRelationshipsWhenHidden()
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
        $this->question ? $this->update() : $this->create();

        $this->redirect(route('hub.quiz-app.edit', $this->quiz));
    }

    public function create(): void
    {
        /** @var QuizQuestion $question */
        $question = QuizQuestion::query()->create($this->form->getState());

        $this->notify($question->translate('name').' quiz created');
    }

    public function update(): void
    {
        $this->question->update($this->form->getState());

        $this->notify($this->question->translate('name').' quiz updated');
    }

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.components.edit-form')
            ->layout('adminhub::layouts.app');
    }
}

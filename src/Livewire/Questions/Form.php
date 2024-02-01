<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Questions;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use XtendLunar\Addons\PageBuilder\Fields\TextInput;
use XtendLunar\Addons\PageBuilder\Fields\TextArea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Card;
use Livewire\Component;
use Lunar\Hub\Http\Livewire\Traits\Notifies;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class Form extends Component implements HasForms
{
    use InteractsWithForms;

    use Notifies;

    public Quiz $quiz;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->quiz->name,
            'heading' => $this->quiz->heading,
            'sub_heading' => $this->quiz->sub_heading,
            'content' => $this->quiz->content,
            'featured_image' => $this->quiz->featured_image,
            'question_duration' => $this->quiz->question_duration,
            'starts_at' => $this->quiz->starts_at,
            'ends_at' => $this->quiz->ends_at,
        ]);
    }

    public function getFormSchema(): array
    {
        return [
            Card::make()->columns(3)->schema([
                TextInput::make('name')->translatable(),
                TextInput::make('heading')->translatable(),
                TextInput::make('sub_heading')->translatable(),
                Textarea::make('content')->translatable()->columnSpanFull(),
                FileUpload::make('featured_image')->image()->columnSpanFull(),
                Card::make()
                    ->schema([
                        TextInput::make('question_duration')->numeric()->required(),
                        DateTimePicker::make('starts_at')->required(),
                        DateTimePicker::make('ends_at')->required(),
                    ])
                    ->columns(3),
            ]),
        ];
    }

    public function submit()
    {
        $quiz = Quiz::create($this->form->getState());

        $this->notify($quiz->name.' quiz updated');

        $this->redirect(route('hub.quiz-app.index'));
    }

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.components.edit-form')
            ->layout('adminhub::layouts.app');
    }
}

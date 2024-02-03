<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Quizzes;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Language;
use XtendLunar\Addons\PageBuilder\Fields\TextInput;
use XtendLunar\Addons\PageBuilder\Fields\RichEditor;
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

    public ?Quiz $quiz = null;

    public function mount(): void
    {
        $state = $this->quiz ? [
            'name' => $this->quiz->name,
            'heading' => $this->quiz->heading,
            'sub_heading' => $this->quiz->sub_heading,
            'featured_image' => $this->quiz->featured_image,
            'question_duration' => $this->quiz->question_duration,
            'starts_at' => $this->quiz->starts_at,
            'ends_at' => $this->quiz->ends_at,
            'active' => $this->quiz->active ?? false,
        ] : [];

        $content = Language::all()->mapWithKeys(fn(Language $language) => [
            'content.' . $language->code => $this->quiz?->translate('content', $language->code),
        ])->toArray();

        $state = array_merge($state, $content);

        $this->form->fill($state);
    }

    public function getFormSchema(): array
    {
        return [
            Toggle::make('active'),
            Card::make()->columns(3)->schema([
                TextInput::make('name')->translatable(),
                TextInput::make('heading')->translatable(),
                TextInput::make('sub_heading')->translatable(),
                RichEditor::make('content')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                    ])
                    ->translatable()
                    ->columnSpanFull(),
                FileUpload::make('featured_image')->image()->columnSpanFull(),
                Card::make()
                    ->schema([
                        TextInput::make('question_duration')->numeric()->required(),
                        DateTimePicker::make('starts_at')
                            ->minDate(today())
                            ->required(),
                        DateTimePicker::make('ends_at')
                            ->minDate(today()->addMonth())
                            ->required(),
                    ])
                    ->columns(3),
            ]),
        ];
    }

    public function submit(): void
    {
        $this->quiz ? $this->update() : $this->create();

        $this->redirect(route('hub.quiz-app.index'));
    }

    public function create(): void
    {
        $state = $this->form->getState();

        $state['handle'] = strtolower(str_replace(' ', '-', $state['name']['en']));

        /** @var Quiz $quiz */
        $quiz = Quiz::query()->create($state);

        $this->createPrizeTiers($quiz);

        $this->notify($quiz->translate('name').' quiz created');
    }

    public function update(): void
    {
        $this->quiz->update($this->form->getState());

        $this->notify($this->quiz->translate('name').' quiz updated');
    }

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.components.edit-form')
            ->layout('adminhub::layouts.app');
    }

    private function createPrizeTiers(Quiz $quiz): void
    {
        $quiz->prizeTiers()->createMany([
            [
                'handle' => 'participation',
                'name' => new TranslatedText(
                    collect([
                        'en' => 'Participation Prize',
                        'fr' => 'Prix de participation',
                        'ar' => 'جائزة المشاركة',
                    ]),
                ),
            ],
            [
                'handle' => 'third_place',
                'name' => new TranslatedText(
                    collect([
                        'en' => '3rd Place Prize',
                        'fr' => 'Prix de 3e place',
                        'ar' => 'الجائزة الثالثة',
                    ]),
                ),
            ],
            [
                'handle' => 'second_place',
                'name' => new TranslatedText(
                    collect([
                        'en' => '2nd Place Prize',
                        'fr' => 'Prix de 2e place',
                        'ar' => 'الجائزة الثانية',
                    ]),
                ),
            ],
            [
                'handle' => 'grand_place',
                'name' => new TranslatedText(
                    collect([
                        'en' => 'Grand Prize',
                        'fr' => 'Grand Prix',
                        'ar' => 'الجائزة الكبرى',
                    ]),
                ),
            ],
        ]);
    }
}

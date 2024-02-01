<div class="flex-col space-y-4">
    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            Edit: {{ $this->question->translate('name') }}
        </strong>

        <div class="text-right">
            <x-hub::button theme="gray" tag="a" href="{{ route('hub.quiz-app.edit', ['quiz' => $this->quiz]) }}">
                {{ __('Back to Quiz') }}
            </x-hub::button>
        </div>
    </div>

    @livewire('xtend-lunar::quiz-app.questions.form', ['quiz' => $this->quiz, 'question' => $this->question])
</div>

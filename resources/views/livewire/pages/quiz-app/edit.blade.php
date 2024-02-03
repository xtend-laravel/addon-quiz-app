<div class="flex-col space-y-4">
    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            Quiz: {{ $this->quiz->translate('name') }}
        </strong>

        <div class="text-right">
            <x-hub::button theme="gray" tag="a" href="{{ route('hub.quiz-app.index') }}">
                {{ __('Back to Quizzes') }}
            </x-hub::button>
        </div>
    </div>

    @livewire('xtend-lunar::quiz-app.quizzes.form', ['quiz' => $this->quiz])

    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            {{ __('Questions') }}
        </strong>

        <div class="text-right">
            <x-hub::button tag="a" href="{{ route('hub.quiz-app.create-question', ['quiz' => $this->quiz]) }}">
                {{ __('Create Question') }}
            </x-hub::button>
        </div>
    </div>

    <div class="pb-20">
        @livewire('xtend-lunar::quiz-app.questions.table', ['quiz' => $this->quiz])
    </div>

    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            {{ __('Prize Tiers') }}
        </strong>

        <div class="text-right">
            <x-hub::button tag="a" href="{{ route('hub.quiz-app.create-prize-tier', ['quiz' => $this->quiz]) }}">
                {{ __('Create Prize Tier') }}
            </x-hub::button>
        </div>
    </div>

    <div class="pb-20">
        @livewire('xtend-lunar::quiz-app.prize-tiers.table', ['quiz' => $this->quiz])
    </div>
</div>

<div class="flex-col space-y-4">
    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            New Quiz
        </strong>

        <div class="text-right">
            <x-hub::button theme="gray" tag="a" href="{{ route('hub.quiz-app.index') }}">
                {{ __('Back to Quizzes') }}
            </x-hub::button>
        </div>
    </div>

    @livewire('xtend-lunar::quiz-app.quizzes.form')
</div>

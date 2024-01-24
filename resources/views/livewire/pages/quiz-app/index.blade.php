<div class="flex-col space-y-4">
    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            {{ __('Quizzes') }}
        </strong>
    </div>

    @livewire('xtend-lunar::quiz-app.quizzes.table')
</div>

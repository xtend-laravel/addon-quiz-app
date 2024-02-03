<div class="flex-col space-y-4">
    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            Edit: {{ $this->prizeTier->translate('name') }}
        </strong>

        <div class="text-right">
            <x-hub::button theme="gray" tag="a" href="{{ route('hub.quiz-app.edit', ['quiz' => $this->quiz]) }}">
                {{ __('Back to Quiz') }}
            </x-hub::button>
        </div>
    </div>

    @livewire('xtend-lunar::quiz-app.prize-tiers.form', ['quiz' => $this->quiz, 'prizeTier' => $this->prizeTier])
</div>

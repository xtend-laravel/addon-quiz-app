<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Pages;

use Livewire\Component;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;

class QuizAppEditPrizeTier extends Component
{
    public Quiz $quiz;

    public QuizPrizeTier $prizeTier;

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.pages.quiz-app.edit-prize-tier')
            ->layout('adminhub::layouts.app');
    }
}

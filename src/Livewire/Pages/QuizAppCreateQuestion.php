<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Pages;

use Livewire\Component;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class QuizAppCreateQuestion extends Component
{
    public Quiz $quiz;

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.pages.quiz-app.create-question')
            ->layout('adminhub::layouts.app');
    }
}

<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Pages;

use Livewire\Component;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class QuizAppEditQuestion extends Component
{
    public Quiz $quiz;

    public QuizQuestion $question;

    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.pages.quiz-app.edit-question')
            ->layout('adminhub::layouts.app');
    }
}

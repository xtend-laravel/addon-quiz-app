<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Pages;

use Livewire\Component;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class QuizAppEdit extends Component
{
    public Quiz $quiz;
    
    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.pages.quiz-app.edit')
            ->layout('adminhub::layouts.app');
    }
}

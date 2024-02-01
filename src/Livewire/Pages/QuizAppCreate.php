<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Pages;

use Livewire\Component;

class QuizAppCreate extends Component
{
    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.pages.quiz-app.create')
            ->layout('adminhub::layouts.app');
    }
}

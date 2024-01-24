<?php

namespace XtendLunar\Addons\QuizApp\Livewire\Pages;

use Livewire\Component;

class QuizAppIndex extends Component
{
    public function render()
    {
        return view('xtend-lunar-quiz-app::livewire.pages.quiz-app.index')
            ->layout('adminhub::layouts.app');
    }
}

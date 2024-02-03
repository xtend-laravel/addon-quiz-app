<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppCreate;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppCreatePrizeTier;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppCreateQuestion;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppEdit;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppEditPrizeTier;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppEditQuestion;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppIndex;

Route::prefix(config('lunar-hub.system.path'))
    ->middleware(['web', Authenticate::class, 'can:settings:core'])
    ->group(function () {
        // @todo Create QuizAppEdit and QuizAppShow page components
        Route::get('/quiz-app', QuizAppIndex::class)->name('hub.quiz-app.index');
        Route::get('/quiz-app/create', QuizAppCreate::class)->name('hub.quiz-app.create');
        Route::get('/quiz-app/{quiz}/edit', QuizAppEdit::class)->name('hub.quiz-app.edit');
        Route::get('/quiz-app/{quiz}/question/create', QuizAppCreateQuestion::class)->name('hub.quiz-app.create-question');
        Route::get('/quiz-app/{quiz}/question/{question}/edit', QuizAppEditQuestion::class)->name('hub.quiz-app.edit-question');
        Route::get('/quiz-app/{quiz}/prize-tier/create', QuizAppCreatePrizeTier::class)->name('hub.quiz-app.create-prize-tier');
        Route::get('/quiz-app/{quiz}/prize-tier/{prizeTier}/edit', QuizAppEditPrizeTier::class)->name('hub.quiz-app.edit-prize-tier');
    });

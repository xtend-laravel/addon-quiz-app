<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppCreate;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppEdit;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppIndex;

Route::prefix(config('lunar-hub.system.path'))
    ->middleware(['web', Authenticate::class, 'can:settings:core'])
    ->group(function () {
        // @todo Create QuizAppEdit and QuizAppShow page components
        Route::get('/quiz-app', QuizAppIndex::class)->name('hub.quiz-app.index');
        Route::get('/quiz-app/create', QuizAppCreate::class)->name('hub.quiz-app.create');
        Route::get('/quiz-app/{quiz}/edit', QuizAppEdit::class)->name('hub.quiz-app.edit');
    });

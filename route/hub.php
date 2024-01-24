<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Addons\QuizApp\Livewire\Pages\QuizAppIndex;

Route::prefix(config('lunar-hub.system.path'))
    ->middleware(['web', Authenticate::class, 'can:settings:core'])
    ->group(function () {
        Route::get('/quiz-app', QuizAppIndex::class)->name('hub.quiz-app.index');
    });

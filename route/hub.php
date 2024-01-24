<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Addons\UserAuditTrail\Livewire\Pages\UserAuditTrailIndex;

Route::prefix(config('lunar-hub.system.path'))
    ->middleware(['web', Authenticate::class, 'can:settings:core'])
    ->group(function () {
        Route::get('/quiz-app', UserAuditTrailIndex::class)->name('hub.quiz-app.index');
    });

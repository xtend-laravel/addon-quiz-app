<?php

namespace XtendLunar\Addons\QuizApp\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Illuminate\Http\Request;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class GenerateUserDiscountAction extends Action
{
    public function handle(Request $request, Quiz $models): \Illuminate\Http\JsonResponse
    {
        return ok();
    }
}

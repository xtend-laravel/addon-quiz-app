<?php

namespace XtendLunar\Addons\QuizApp\Restify\Getters;

use Binaryk\LaravelRestify\Getters\Getter;
use Binaryk\LaravelRestify\Http\Requests\GetterRequest;
use Illuminate\Http\JsonResponse;

class UserQuizResults extends Getter
{
    public static $uriKey = 'user-quiz-results';

    public function handle(GetterRequest $request): JsonResponse
    {
        return data([

        ]);
    }
}

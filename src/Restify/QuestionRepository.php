<?php

namespace XtendLunar\Addons\QuizApp\Restify;

use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Restify\Getters\QuizAnswersGetter;
use XtendLunar\Addons\QuizApp\Restify\Presenters\QuestionPresenter;
use XtendLunar\Addons\RestifyApi\Restify\Repository;

class QuestionRepository extends Repository
{
    public static string $presenter = QuestionPresenter::class;

    public static string $model = QuizQuestion::class;

    public function getters(RestifyRequest $request): array
    {
        return [
            QuizAnswersGetter::new(),
        ];
    }
}

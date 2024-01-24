<?php

namespace XtendLunar\Addons\QuizApp\Restify;

use XtendLunar\Addons\QuizApp\Restify\Presenters\QuestionPresenter;
use XtendLunar\Addons\RestifyApi\Restify\Repository;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class QuestionRepository extends Repository
{
    public static string $presenter = QuestionPresenter::class;

    public static string $model = Quiz::class;
}

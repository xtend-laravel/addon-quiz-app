<?php

namespace XtendLunar\Addons\QuizApp\Restify;

use XtendLunar\Addons\QuizApp\Models\QuizAnswer;
use XtendLunar\Addons\QuizApp\Restify\Presenters\QuizAnswerPresenter;
use XtendLunar\Addons\RestifyApi\Restify\Repository;

class QuizAnswerRepository extends Repository
{
    public static string $presenter = QuizAnswerPresenter::class;

    public static string $model = QuizAnswer::class;
}

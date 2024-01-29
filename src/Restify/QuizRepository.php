<?php

namespace XtendLunar\Addons\QuizApp\Restify;

use Binaryk\LaravelRestify\Fields\HasMany;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use XtendLunar\Addons\QuizApp\Restify\Actions\GenerateUserDiscountAction;
use XtendLunar\Addons\QuizApp\Restify\Actions\ValidateUserQuizAction;
use XtendLunar\Addons\QuizApp\Restify\Getters\UserQuizResults;
use XtendLunar\Addons\RestifyApi\Restify\Repository;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Restify\Presenters\QuizPresenter;

class QuizRepository extends Repository
{
    public static string $presenter = QuizPresenter::class;

    public static string $model = Quiz::class;

    public static function related(): array
    {
        return [
            HasMany::make('quizQuestions', QuestionRepository::class),
        ];
    }

    public function actions(RestifyRequest $request): array
    {
        return [
            ValidateUserQuizAction::new()->onlyOnIndex(),
            GenerateUserDiscountAction::new()->onlyOnShow(),
        ];
    }
}

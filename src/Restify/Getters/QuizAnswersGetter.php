<?php

namespace XtendLunar\Addons\QuizApp\Restify\Getters;

use Binaryk\LaravelRestify\Getters\Getter;
use Binaryk\LaravelRestify\Http\Requests\GetterRequest;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Http\JsonResponse;
use Lunar\Models\Product;
use XtendLunar\Addons\QuizApp\Models\QuizAnswer;
use XtendLunar\Addons\QuizApp\Restify\QuestionRepository;

class QuizAnswersGetter extends Getter
{
    public static $uriKey = 'quiz-answers';

    public function handle(GetterRequest|RestifyRequest $request, QuestionRepository $model): JsonResponse
    {
        $question = $model->model();;

        return response()->json([
            $question->answers->map(fn (QuizAnswer $answer) => [
                'id' => $answer->id,
                'answer' => $answer->translate('name'),
                'is_correct' => $answer->is_correct,
            ]),
        ]);
    }
}

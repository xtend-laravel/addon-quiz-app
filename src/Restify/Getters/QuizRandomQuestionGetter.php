<?php

namespace XtendLunar\Addons\QuizApp\Restify\Getters;

use Binaryk\LaravelRestify\Getters\Getter;
use Binaryk\LaravelRestify\Http\Requests\GetterRequest;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizAnswer;

class QuizRandomQuestionGetter extends Getter
{
    public static $uriKey = 'quiz-random-question';

    public function handle(GetterRequest|RestifyRequest $request, Quiz $model): JsonResponse
    {
        /** @var \XtendLunar\Addons\QuizApp\Models\Quiz $quiz */
        $quiz = $model;
        $excludeQuestionIds = Str::of($request->input('exclude_question_ids'))->explode(',')->filter();

        /** @var \XtendLunar\Addons\QuizApp\Models\QuizQuestion $question */
        try {
            $question = $quiz->quizQuestions()
                ->whereNotIn('id', $excludeQuestionIds)
                ->inRandomOrder()
                ->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'id' => $question->id,
            'question' => $question->translate('name'),
            'answers' => $question->answers->shuffle()->map(fn (QuizAnswer $answer) => [
                'id' => $answer->id,
                'answer' => $answer->translate('name'),
            ]),
        ]);
    }
}

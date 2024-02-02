<?php

namespace XtendLunar\Addons\QuizApp\Restify\Getters;

use Binaryk\LaravelRestify\Getters\Getter;
use Binaryk\LaravelRestify\Http\Requests\GetterRequest;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Http\JsonResponse;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class CurrentRunningQuizGetter extends Getter
{
    public static $uriKey = 'current-running-quiz';

    public function handle(GetterRequest|RestifyRequest $request): JsonResponse
    {
        try {
            $currentQuiz = Quiz::query()->where('active', true)->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'quiz' => $currentQuiz,
            'questionNb' => $currentQuiz->quizQuestions()->count(),
        ]);
    }
}

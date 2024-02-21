<?php

namespace XtendLunar\Addons\QuizApp\Restify\Getters;

use Binaryk\LaravelRestify\Getters\Getter;
use Binaryk\LaravelRestify\Http\Requests\GetterRequest;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class CurrentRunningQuizGetter extends Getter
{
    public static $uriKey = 'current-running-quiz';

    public function handle(GetterRequest|RestifyRequest $request): JsonResponse
    {
        /** @var Quiz $currentQuiz */
        $currentQuiz = Quiz::query()
            ->where('active', true)
            ->where('ends_at', '>', now())
            ->first();

        if (!$currentQuiz) {
            return response()->json([
                'quiz' => null,
                'questionNb' => 0,
            ]);
        }

        if ($this->userAlreadyTakenQuiz($currentQuiz)) {
            return response()->json([
                'quiz' => null,
                'questionNb' => 0,
                'message' => 'You have already taken this quiz.',
            ]);
        }

        $hasFeaturedImage = $currentQuiz->featured_image && Storage::disk('do')->exists($currentQuiz->featured_image);
        return response()->json([
            'quiz' => [
              ...$currentQuiz->toArray(),
              'featured_image' => $hasFeaturedImage ? Storage::disk('do')->url($currentQuiz->featured_image) : null,
            ],
            'questionNb' => $currentQuiz->quizQuestions()->count(),
        ]);
    }

    protected function userAlreadyTakenQuiz(Quiz $quiz)
    {
        return $quiz->responses()->where('user_id', auth()->id())->exists();
    }
}

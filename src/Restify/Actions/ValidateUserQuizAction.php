<?php
namespace XtendLunar\Addons\QuizApp\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;

class ValidateUserQuizAction extends Action
{
    protected Collection $payload;

    protected QuizUserResponse $userResponse;

    public function handle(Request $request, Quiz $models): JsonResponse
    {
        $quiz = $models;
        $this->payload = collect($request->payload ?? []);

        $this->userResponse = $quiz->responses()->create([
           'user_id' => $request->user()->id,
           'payload' => $this->payload,
        ]);

        $this->calculateElapsedTime();
        $this->calculateScore();

        return data([
            'message' => 'Quiz successfully submitted.',
            'data' => $this->userResponse,
        ]);
    }

    protected function calculateElapsedTime(): void
    {
        $this->userResponse->update([
            'total_elapsed_time' => $this->payload->sum('elapsed_time'),
        ]);
    }

    protected function calculateScore(): void
    {
        $questionsNb = $this->payload->count();
        $correctAnswersNb = $this->payload->filter(function ($item) {
            $question = QuizQuestion::find($item['question_id']);
            return $question->checkCorrectAnswer($item['answer_id']);
        })->count();

        $this->userResponse->update([
            'total_score' => round(($correctAnswersNb / $questionsNb) * 100),
        ]);
    }
}

<?php
namespace XtendLunar\Addons\QuizApp\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;

class ValidateUserQuizAction extends Action
{
    protected Collection $payload;

    protected QuizUserResponse $userResponse;

    protected string $message = '';

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
            'message' => $this->message,
            'price_tier' => $this->checkPriceTierEligibility(),
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

    /**
     * @todo Move during API refactor
     */
    protected function checkPriceTierEligibility()
    {
        if ($this->userResponse->total_score < 70) {
            return $this->takingPartEligibility();
        }

        if ($this->userResponse->total_score >= 70 && $this->userResponse->total_score < 90) {
            return $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'third_place');
        }

        if ($this->userResponse->total_score >= 90 && $this->userResponse->total_score < 100) {
            return $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'second_place');
        }

        return $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'grand_prize');
    }

    protected function takingPartEligibility(): ?QuizPrizeTier
    {
        $questionsNb = $this->payload->count();

        $questionsAnsweredNb = $this->payload->filter(fn($item) => $item['answer_id'] > 0)->count();

        if ($questionsAnsweredNb < $questionsNb / 2) {
            $this->message = 'You need to answer at least half of the questions to be eligible for the lowest prize tier';
            return null;
        }

        $this->message = 'You are eligible for the lowest prize tier';

        return $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'participation');
    }
}

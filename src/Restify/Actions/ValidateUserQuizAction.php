<?php
namespace XtendLunar\Addons\QuizApp\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Lunar\DiscountTypes\AmountOff;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;

class ValidateUserQuizAction extends Action
{
    protected Quiz $quiz;

    protected Collection $payload;

    protected QuizUserResponse $userResponse;

    protected string $message = '';

    public function handle(Request $request, Quiz $models): JsonResponse
    {
        $this->quiz = $models;
        $this->payload = collect($request->payload ?? []);

        $this->userResponse = $this->quiz->responses()->create([
           'user_id' => $request->user()->id,
           'payload' => $this->payload,
        ]);

        $this->calculateElapsedTime();
        $this->calculateScore();

        return data([
            'message' => $this->message,
            'score' => $this->userResponse->total_score,
            'price_tier' => $this->checkPriceTierEligibility(),
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
            return $question?->checkCorrectAnswer($item['answer_id']);
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
            $prizeTier = $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'third_place');
            $this->generateDiscount($prizeTier);
            return $prizeTier;
        }

        if ($this->userResponse->total_score >= 90 && $this->userResponse->total_score < 100) {
            $prizeTier = $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'second_place');
            $this->generateDiscount($prizeTier);
            return $prizeTier;
        }

        $prizeTier = $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'grand_prize');

        $this->generateDiscount($prizeTier);

        return $prizeTier;
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

        $prizeTier = $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'participation');

        $this->generateDiscount($prizeTier);

        return $prizeTier;
    }

    protected function generateDiscount(QuizPrizeTier $prizeTier): void
    {
        if (!$prizeTier->percentage_off) {
            return;
        }

        /** @var \Lunar\Models\Discount $discount */
        $discount = $prizeTier->discount()->updateOrCreate([
            'handle' => $prizeTier->handle.'_discount'.'_'.$this->userResponse->user_id,
        ], [
            'name' => $prizeTier->translate('name'). ' Discount',
            'type' => AmountOff::class,
            'data' => [
                'percentage' => (int)$prizeTier->percentage_off,
                'fixed_value' => false,
            ],
            'starts_at' => $this->quiz->starts_at,
            'expires_at' => $this->quiz->ends_at,
        ]);

        $discount->users()->syncWithoutDetaching($this->userResponse->user_id);

        $discount->update([
            'coupon' => $this->generateUserCouponCode(),
        ]);
    }

    protected function generateUserCouponCode(): string
    {
        $randomId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $userId = str_pad($this->userResponse->user_id, 4, '0', STR_PAD_LEFT);
        return "AWR-{$this->quiz->id}-{$randomId}-{$userId}";
    }
}

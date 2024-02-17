<?php
namespace XtendLunar\Addons\QuizApp\Restify\Actions;

use App\Models\User;
use Binaryk\LaravelRestify\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Lunar\DiscountTypes\AmountOff;
use Lunar\Models\Discount;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;
use XtendLunar\Addons\QuizApp\Notifications\QuizPrizeTierNotification;

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

        $priceTier = $this->checkPriceTierEligibility();

        return data([
            'message' => $this->message,
            'score' => $this->userResponse->total_score,
            'finalist' => $this->userResponse->total_score === 100,
            'price_tier' => $priceTier ? [
                'name' => $priceTier->translate('name'),
                'percentage' => $priceTier->percentage_off,
                'discount' => [
                    'coupon' => $priceTier->discount?->coupon,
                    'name' => $priceTier->discount?->name,
                    'ends_at' => $priceTier->discount?->ends_at->format('d M Y'),
                ]
            ] : null,
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

        $prizeTier = $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'second_place');
        if ($this->userResponse->total_score >= 90 && $this->userResponse->total_score < 100) {
            $this->generateDiscount($prizeTier);
            return $prizeTier;
        }


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

        /** @var QuizPrizeTier $prizeTier */
        $prizeTier = $this->userResponse->quiz->prizeTiers()->firstWhere('handle', 'participation');

        $discount = $this->generateDiscount($prizeTier);

        if ($discount) {
            $prizeTier->discount()->associate($discount);
            $prizeTier->save();
        }

        return $prizeTier->fresh();
    }

    protected function generateDiscount(QuizPrizeTier $prizeTier): ?Discount
    {
        if (!$prizeTier->percentage_off) {
            return null;
        }

        /** @var \Lunar\Models\Discount $discount */
        $discount = Discount::query()->firstWhere('handle', $prizeTier->handle.'_discount'.'_'.$this->userResponse->user_id);
        if (!$discount) {
            $discount = $prizeTier->discount()->create([
                'handle' => $prizeTier->handle.'_discount'.'_'.$this->userResponse->user_id,
                'name' => $prizeTier->translate('name'). ' Discount',
                'type' => AmountOff::class,
                'data' => [
                    'percentage' => (int)$prizeTier->percentage_off,
                    'fixed_value' => false,
                ],
                'starts_at' => $this->quiz->starts_at,
                'ends_at' => $this->quiz->ends_at,
            ]);
        } else {
            $discount->update([
                'data' => [
                    'percentage' => (int)$prizeTier->percentage_off,
                    'fixed_value' => false,
                ],
            ]);
        }

        $user = User::find($this->userResponse->user_id);
        $discount->users()->syncWithoutDetaching($user->id);

        $user->notify(new QuizPrizeTierNotification($user, $prizeTier));

        $discount->update([
            'coupon' => $this->generateUserCouponCode(),
        ]);

        return $discount;
    }

    protected function generateUserCouponCode(): string
    {
        $randomId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $userId = str_pad($this->userResponse->user_id, 4, '0', STR_PAD_LEFT);
        return "AWR-Q{$this->quiz->id}-{$randomId}-{$userId}";
    }
}

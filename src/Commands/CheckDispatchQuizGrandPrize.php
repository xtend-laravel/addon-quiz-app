<?php

namespace XtendLunar\Addons\QuizApp\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Lunar\DiscountTypes\AmountOff;
use Lunar\Models\Discount;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;
use XtendLunar\Addons\QuizApp\Notifications\QuizWinnerNotification;

class CheckDispatchQuizGrandPrize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz-app:check-dispatch-grand-prize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check and dispatch the grand prize to the winner of the quiz.';

    protected ?Quiz $quiz;

    protected User $user;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Do we have a quiz that is active and ended in the last 10 minutes?
        $this->quiz = Quiz::active()->whereDate('ends_at', now())->first();
        if (!$this->quiz) {
            $this->components->warn('No active quiz found which ended today.');
            return self::SUCCESS;
        }

        $this->determineGrandPrizeUser()
            ? $this->dispatchGrandPrize()
            : $this->components->warn('No grand prize winner found.');

        return self::SUCCESS;
    }

    protected function determineGrandPrizeUser(): bool
    {
        /* @var \XtendLunar\Addons\QuizApp\Models\QuizUserResponse $fastestTime */
        $fastestTime = $this->quiz->responses()
            ->where('total_score', '>=', 70)
            ->orderBy('total_score', 'desc')
            ->orderBy('total_elapsed_time')
            ->first();

        $this->user = $fastestTime->user;

        return !!$fastestTime;
    }

    protected function dispatchGrandPrize(): void
    {
        $this->components->info('Grand prize dispatched to the winner.');

        /** @var QuizPrizeTier $prizeTier */
        $prizeTier = $this->quiz->prizeTiers()->firstWhere('handle', 'grand_finalist');

        if (!$prizeTier) {
            $this->components->warn('No grand prize tier found.');
            return;
        }

        $discount = $this->generateDiscount($prizeTier);

        $this->user->notify(new QuizWinnerNotification($this->user, $discount));
    }

    protected function generateDiscount(QuizPrizeTier $prizeTier): ?Discount
    {
        /** @var \Lunar\Models\Discount $discount */
        $discount = Discount::query()->firstWhere('handle', $prizeTier->handle.'_discount'.'_'.$this->user->id);
        if (!$discount) {
            $discount = $prizeTier->discount()->create([
                'handle' => $prizeTier->handle.'_discount'.'_'.$this->user->id,
                'name' => $prizeTier->translate('name'). ' Discount',
                'type' => AmountOff::class,
                'data' => [
                    'percentage' => 100,
                    'fixed_value' => false,
                ],
                'starts_at' => $this->quiz->starts_at,
                'ends_at' => $this->quiz->ends_at,
                'priority' => 10,
                'stop' => true,
            ]);
        } else {
            $discount->update([
                'data' => [
                    'percentage' => (int)$prizeTier->percentage_off,
                    'fixed_value' => false,
                ],
            ]);
        }

        $discount->users()->detach();
        $discount->users()->attach($this->user->id);
        $discount->channels()->sync([1]);

        $discount->update([
            'coupon' => $this->generateUserCouponCode(),
        ]);

        return $discount;
    }

    protected function generateUserCouponCode(): string
    {
        $randomId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $userId = str_pad($this->user->id, 4, '0', STR_PAD_LEFT);
        return "AWR-Q{$this->quiz->id}-{$randomId}-{$userId}";
    }
}

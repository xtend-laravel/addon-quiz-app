<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\UserQuizProgress;

class UserQuizProgressFactory extends Factory
{
    protected $model = UserQuizProgress::class;

    public function definition(): array
    {
        $userIds = \App\Models\User::pluck('id')->toArray();
        $quizIds = \XtendLunar\Addons\QuizApp\Models\Quiz::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'quiz_id' => $this->faker->randomElement($quizIds),
            'progress' => $this->faker->numberBetween(0, 100),
            'elapsed_time' => $this->faker->numberBetween(1, 3600),
        ];
    }
}

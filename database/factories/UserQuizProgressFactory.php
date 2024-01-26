<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\UserQuizProgress;

class UserQuizProgressFactory extends Factory
{
    protected $model = UserQuizProgress::class;

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'quiz_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\Quiz::factory()->create()->id;
            },
            'progress' => $this->faker->numberBetween(0, 100),
            'elapsed_time' => $this->faker->numberBetween(1, 3600),
        ];
    }
}

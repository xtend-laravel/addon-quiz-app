<?php

namespace QuizApp\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\UserQuizProgress;

class UserQuizProgressFactory extends Factory
{
    protected $model = UserQuizProgress::class;

    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'quiz_id' => Quiz::query()->inRandomOrder()->first()->id,
            'progress' => $this->faker->numberBetween(0, 100),
            'elapsed_time' => $this->faker->numberBetween(10, 3600),
        ];
    }
}

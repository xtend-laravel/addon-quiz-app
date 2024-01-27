<?php

namespace QuizApp\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\UserResponse;

class UserResponsesFactory extends Factory
{
    protected $model = UserResponse::class;

    public function definition(): array
    {
        $question = QuizQuestion::query()->inRandomOrder()->first();

        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'question_id' => $question->id,
            'answer_id' => $question->answers()->inRandomOrder()->first()?->id,
            'answered_duration' => $this->faker->numberBetween(1, 300),
            'answered_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}

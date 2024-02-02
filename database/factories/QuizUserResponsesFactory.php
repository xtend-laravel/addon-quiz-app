<?php

namespace QuizApp\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;

class UserResponsesFactory extends Factory
{
    protected $model = QuizUserResponse::class;

    public function definition(): array
    {
        $question = QuizQuestion::query()->inRandomOrder()->first();

        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'payload' => [
                'question_id' => $question->id,
                'answer_id' => $question->answers->random()->id ?? null,
                'elapse_time' => rand(1, 10),
            ],
            'total_score' => rand(20, 100),
            'total_elapsed_time' => rand(20, 100),
        ];
    }
}

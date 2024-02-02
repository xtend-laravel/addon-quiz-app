<?php

namespace QuizApp\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;

class UserResponsesFactory extends Factory
{
    protected $model = QuizUserResponse::class;

    public function definition(): array
    {
        /** @var \XtendLunar\Addons\QuizApp\Models\Quiz */
        $quiz = Quiz::query()->inRandomOrder()->first();

        /** @var \XtendLunar\Addons\QuizApp\Models\QuizQuestion $question */
        $question = $quiz->quizQuestions()->inRandomOrder()->first();

        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'quiz_id' => $quiz->id,
            'payload' => [
                'question_id' => $question->id,
                'answer_id' => $question->answers()->inRandomOrder()->first()->id,
                'elapse_time' => rand(1, 10),
            ],
            'total_score' => rand(20, 100),
            'total_elapsed_time' => rand(20, 100),
        ];
    }
}

<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\UserResponses;

class UserResponsesFactory extends Factory
{
    protected $model = UserResponses::class;

    public function definition(): array
    {
        $userIds = \App\Models\User::pluck('id')->toArray();
        $quizQuestionIds = \XtendLunar\Addons\QuizApp\Models\QuizQuestion::pluck('id')->toArray();
        $answerIds = \XtendLunar\Addons\QuizApp\Models\Answers::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'question_id' => $this->faker->randomElement($quizQuestionIds),
            'answer_id' => $this->faker->randomElement($answerIds),
            'answered_duration' => $this->faker->numberBetween(1, 300),
            'answered_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}

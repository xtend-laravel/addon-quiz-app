<?php

namespace UserAuditTrail\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\UserResponses;

class UserResponsesFactory extends Factory
{
    protected $model = UserResponses::class;

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\User::factory()->create()->id;
            },
            'question_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\Question::factory()->create()->id;
            },
            'answer_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\Answer::factory()->create()->id;
            },
            'answered_duration' => $this->faker->numberBetween(1, 300),
            'answered_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}

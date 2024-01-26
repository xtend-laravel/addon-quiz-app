<?php

namespace UserAuditTrail\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\Answers;

class AnswerFactory extends Factory
{
    protected $model = Answers::class;

    public function definition(): array
    {
        return [
            'question_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\QuizQuestion::factory()->create()->id;
            },
            'handle' => $this->faker->word,
            'name' => [
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
                'fr' => $this->faker->sentence,
            ]
        ];
    }
}

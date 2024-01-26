<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition(): array
    {
        return [
            'quiz_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\Quiz::factory()->create()->id;
            },
            'correct_answer_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\AnswerFactory::factory()->create()->id;
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

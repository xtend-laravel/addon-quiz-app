<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\Answers;

class AnswerFactory extends Factory
{
    protected $model = Answers::class;

    public function definition(): array
    {
        $quizQuestionIds = \XtendLunar\Addons\QuizApp\Models\QuizQuestion::pluck('id')->toArray();
        return [
            'question_id' => $this->faker->randomElement($quizQuestionIds),
            'handle' => $this->faker->word,
            'name' => [
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
                'fr' => $this->faker->sentence,
            ]
        ];
    }
}

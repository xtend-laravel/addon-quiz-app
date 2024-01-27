<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition(): array
    {
        $answerIds = \XtendLunar\Addons\QuizApp\Models\Answers::pluck('id')->toArray();
        
        return [
            'quiz_id' => \XtendLunar\Addons\QuizApp\Models\Quiz::factory(),
            'correct_answer_id' => $this->faker->randomElement($answerIds),
            'handle' => $this->faker->word,
            'name' => [
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
                'fr' => $this->faker->sentence,
            ]
        ];
    }
}

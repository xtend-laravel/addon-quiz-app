<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use XtendLunar\Addons\QuizApp\Models\QuizAnswer;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class AnswerFactory extends Factory
{
    protected $model = QuizAnswer::class;

    public function definition(): array
    {
        return [
            'quiz_question_id' => QuizQuestion::query()->inRandomOrder()->first()->id,
            'handle' => $this->faker->word,
            'is_correct' => $this->faker->boolean(10),
            'name' => new TranslatedText([
                'en' => new Text($this->faker->sentence),
            ]),
        ];
    }
}

<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::query()->inRandomOrder()->first()->id,
            'handle' => $this->faker->word,
            'name' => new TranslatedText([
                'en' => new Text($this->faker->sentence),
            ]),
        ];
    }
}

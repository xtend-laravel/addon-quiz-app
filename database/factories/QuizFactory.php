<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        /** @var Quiz $lastQuiz */
        $lastQuiz = Quiz::query()->latest()->first();
        $name = $this->faker->word;

        return [
            'handle' => Str::of($name)->slug(),
            'name' => new TranslatedText([
                'en' => new Text($name),
            ]),
            'content' => new TranslatedText([
                'en' => new Text($this->faker->paragraph),
            ]),
            'featured_image' => $this->faker->imageUrl(),
            'question_duration' => $this->faker->numberBetween(1, 60),
            'starts_at' => $lastQuiz ? $lastQuiz->starts_at->addMonth() : $this->faker->dateTimeThisMonth(),
            'ends_at' => $lastQuiz ? $lastQuiz->ends_at->addMonths(2) : $this->faker->dateTimeThisMonth('+1 month'),
        ];
    }
}

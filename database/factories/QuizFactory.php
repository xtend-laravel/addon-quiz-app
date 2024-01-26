<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\Quiz;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'content' => [
                'en' => $this->faker->paragraph,
                'ar' => $this->faker->paragraph,
                'fr' => $this->faker->paragraph,
            ],
            'featured_image' => $this->faker->imageUrl(),
            'question_duration' => $this->faker->numberBetween(1, 60),
            'starts_at' => $this->faker->dateTimeThisYear(),
            'ends_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}

<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTiers;

class QuizPrizeTiersFactory extends Factory
{
    protected $model = QuizPrizeTiers::class;

    public function definition(): array
    {
        $quizIds = \XtendLunar\Addons\QuizApp\Models\Quiz::pluck('id')->toArray();

        return [
            'quiz_id' => $this->faker->randomElement($quizIds),
            'discount_id' => '',
            'name' => $this->faker->word,
            'percentage_off' => $this->faker->numberBetween(1, 100),
            'rules' => $this->faker->optional()->randomElement([null, json_encode(['rule1' => 'value1', 'rule2' => 'value2'])]),
        ];
    }
}

<?php

namespace UserAuditTrail\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTiers;

class QuizPrizeTiersFactory extends Factory
{
    protected $model = QuizPrizeTiers::class;

    public function definition(): array
    {
        return [
            'quiz_id' => function () {
                return \XtendLunar\Addons\QuizApp\Models\Quiz::factory()->create()->id;
            },
            'discount_id' => function () {
                // return \XtendLunar\Addons\QuizApp\Models\Discount::factory()->create()->id;
            },
            'name' => $this->faker->word,
            'percentage_off' => $this->faker->numberBetween(1, 100),
            'rules' => $this->faker->optional()->randomElement([null, json_encode(['rule1' => 'value1', 'rule2' => 'value2'])]),
        ];
    }
}

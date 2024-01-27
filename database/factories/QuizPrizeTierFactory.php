<?php

namespace QuizApp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Discount;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;

class QuizPrizeTierFactory extends Factory
{
    protected $model = QuizPrizeTier::class;

    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::query()->inRandomOrder()->first()->id,
            'discount_id' => Discount::query()->inRandomOrder()->first()?->id,
            'name' => new TranslatedText([
                'en' => new Text($this->faker->word),
            ]),
            'percentage_off' => $this->faker->numberBetween(1, 100),
            'rules' => $this->faker->optional()->randomElement([null, json_encode(['rule1' => 'value1', 'rule2' => 'value2'])]),
        ];
    }
}

<?php

namespace QuizApp\Database\Seeders;

use Illuminate\Database\Seeder;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizAnswer;

use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;
use XtendLunar\Addons\QuizApp\Models\QuizUserResponse;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizzes = Quiz::factory()->count(6)
            ->has(
                factory: QuizQuestion::factory()
                    ->count(50)
                    ->has(
                        factory: QuizAnswer::factory()->count(4)
                    )
            )
            ->create();

        $quizzes->last()->update(['active' => true]);

        QuizQuestion::all()->each(function ($question) {
            $question->answers()->inRandomOrder()->first()->update(['is_correct' => true]);
        });

        QuizUserResponse::factory()->count(6)->create();
        QuizPrizeTier::factory()->count(6)->create();
    }
}

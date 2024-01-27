<?php

namespace QuizApp\Database\Seeders;

use Illuminate\Database\Seeder;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\QuizAnswer;

use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;
use XtendLunar\Addons\QuizApp\Models\UserQuizProgress;
use XtendLunar\Addons\QuizApp\Models\UserResponse;
use function Amp\Parallel\Worker\factory;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quiz = Quiz::factory()->count(6)
            ->has(
                factory: QuizQuestion::factory()
                    ->count(50)
                    ->has(
                        factory: QuizAnswer::factory()->count(4)
                    )
            )
            ->create();

        // @todo UserResponse and QuizPrizeTier should be a relationship to Quiz

        UserResponse::factory()->count(6)->create();
        QuizPrizeTier::factory()->count(6)->create();
    }
}

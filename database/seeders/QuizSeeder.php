<?php

namespace QuizApp\Database\Seeders;

use Illuminate\Database\Seeder;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Models\Answers;

use XtendLunar\Addons\QuizApp\Models\QuizPrizeTiers;
use XtendLunar\Addons\QuizApp\Models\UserQuizProgress;
use XtendLunar\Addons\QuizApp\Models\UserResponses;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = Answers::factory()->count(4);

        $questions = QuizQuestion::factory()->count(50)
            ->has($answers)
            ->create();

        $quiz = Quiz::factory()->count(6)
            ->has($questions)
            ->create();

        Quiz::factory()->count(6)->create();
        UserResponses::factory()->count(6)->create();
        QuizPrizeTiers::factory()->count(6)->create();
    }
}

<?php

namespace QuizApp\Database\Seeders;

use Illuminate\Database\Seeder;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quiz::factory()->count(5)->create();
    }
}

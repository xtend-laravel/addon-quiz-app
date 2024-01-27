<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('xtend_quiz_prize_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('xtend_quizzes');
            $table->foreignId('discount_id')->nullable();
            $table->string('handle');
            $table->json('name')->nullable();
            $table->integer('percentage_off')->nullable();
            $table->json('rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xtend_quiz_prize_tiers');
    }
};

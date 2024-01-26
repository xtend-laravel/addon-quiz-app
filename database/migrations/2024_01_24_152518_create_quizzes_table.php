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
        Schema::create('xtend_quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('name')->nullable();
            $table->json('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->integer('question_duration');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xtend_quizzes');
    }
};

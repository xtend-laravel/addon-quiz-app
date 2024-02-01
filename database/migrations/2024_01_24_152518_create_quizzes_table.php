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
            $table->string('handle')->unique();
            $table->json('name')->nullable();
            $table->json('heading')->nullable();
            $table->json('sub_heading')->nullable();
            $table->json('content')->nullable();
            $table->string('theme_style')->nullable();
            $table->string('featured_image')->nullable();
            $table->integer('question_duration')->default(5);
            $table->boolean('active')->default(false);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
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

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
            $table->foreignId('quiz_id')->constrained();
            $table->foreignId('discount_id')->constrained();
            $table->string('name');
            $table->integer('percentage_off');
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

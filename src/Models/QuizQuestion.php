<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\hasMany;
use QuizApp\Database\Factories\QuizQuestionFactory;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_questions';

    protected $fillable = [
        'quiz_id',
        'correct_answer_id',
        'handle',
        'name'
    ];

    protected $casts = [
        'name' => 'json',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function correctAnswer()
    {
        return $this->hasOne(Answers::class, 'correct_answer_id');
    }

    public function answers()
    {
        return $this->hasMany(Answers::class);
    }

    protected static function newFactory(): QuizQuestionFactory
    {
        return QuizQuestionFactory::new();
    }
}

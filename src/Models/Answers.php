<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\AnswerFactory;

class Answers extends Model
{
    use HasFactory;

    protected $table = 'xtend_answers';

    protected $casts = [
        'name' => 'array'
    ];

    protected $fillable = [
        'question_id',
        'handle',
        'name'
    ];

    protected static function newFactory(): AnswerFactory
    {
        return AnswerFactory::new();
    }

    public function question(): BelongsTo
    {
        return $this->BelongsTo(QuizQuestion::class);
    }
}

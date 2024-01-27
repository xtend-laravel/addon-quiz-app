<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\AnswerFactory;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_answers';

    protected $fillable = [
        'question_id',
        'handle',
        'name',
        'is_correct',
    ];

    protected $casts = [
        'name' => AsCollection::class,
        'is_correct' => 'boolean',
    ];

    protected static function newFactory(): AnswerFactory
    {
        return AnswerFactory::new();
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}

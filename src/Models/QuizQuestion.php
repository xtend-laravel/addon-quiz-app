<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UserAuditTrail\Database\Factories\QuizQuestionFactory;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_questions';

    protected $casts = [

    ];

    protected $fillable = [

    ];

    protected static function newFactory(): QuizQuestionFactory
    {
        return QuizQuestionFactory::new();
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}

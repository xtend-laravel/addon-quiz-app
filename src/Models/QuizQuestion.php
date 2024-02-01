<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lunar\Base\Traits\HasTranslations;
use QuizApp\Database\Factories\QuizQuestionFactory;

class QuizQuestion extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'xtend_quiz_questions';

    protected $fillable = [
        'quiz_id',
        'handle',
        'name'
    ];

    protected $casts = [
        'name' => AsCollection::class,
    ];

    protected static function newFactory(): QuizQuestionFactory
    {
        return QuizQuestionFactory::new();
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function quizAnswers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }
}

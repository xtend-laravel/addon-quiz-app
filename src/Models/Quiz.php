<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use UserAuditTrail\Database\Factories\QuizFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'xtend_quizzes';

    protected $casts = [

    ];

    protected $fillable = [

    ];

    protected static function newFactory(): QuizFactory
    {
        return QuizFactory::new();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }
}

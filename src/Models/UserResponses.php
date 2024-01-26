<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\UserResponsesFactory;

class UserResponses extends Model
{
    use HasFactory;

    protected $table = 'xtend_user_responses';

    protected $casts = [
    ];

    protected $fillable = [
        'user_id',
        'question_id',
        'answer_id',
        'answered_duration',
        'answered_at'
    ];

    protected static function newFactory(): UserResponsesFactory
    {
        return UserResponsesFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): belongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function answer(): belongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}

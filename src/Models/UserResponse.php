<?php

namespace XtendLunar\Addons\QuizApp\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\UserResponsesFactory;

class UserResponse extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_user_responses';

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
        return $this->belongsTo(QuizQuestion::class);
    }

    public function answer(): belongsTo
    {
        return $this->belongsTo(QuizAnswer::class);
    }
}

<?php

namespace XtendLunar\Addons\QuizApp\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\UserResponsesFactory;

class QuizUserResponse extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_user_responses';

    protected $fillable = [
        'user_id',
        'payload',
        'total_score',
        'total_elapsed_time',
        'completed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'completed_at' => 'datetime',
    ];

    protected static function newFactory(): UserResponsesFactory
    {
        return UserResponsesFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

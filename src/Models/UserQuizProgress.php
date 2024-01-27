<?php

namespace XtendLunar\Addons\QuizApp\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\UserQuizProgressFactory;

class UserQuizProgress extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_user_progress';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'progress',
        'elapsed_time'
    ];

    protected static function newFactory(): UserQuizProgressFactory
    {
        return UserQuizProgressFactory::new();
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): belongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}

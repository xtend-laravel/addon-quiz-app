<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use QuizApp\Database\Factories\QuizFactory;

/**
 * @property int id
 * @property string name
 * @property mixed content
 * @property string featured_image
 * @property int question_duration
 * @property \Carbon\Carbon starts_at
 * @property \Carbon\Carbon ends_at
 */
class Quiz extends Model
{
    use HasFactory;

    protected $table = 'xtend_quizzes';

    protected $fillable = [
        'name',
        'content',
        'featured_image',
        'question_duration',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'name' => AsCollection::class,
        'content' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function newFactory(): QuizFactory
    {
        return QuizFactory::new();
    }

    public function quizQuestion(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }
}

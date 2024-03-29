<?php

namespace XtendLunar\Addons\QuizApp\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lunar\Base\Traits\HasTranslations;
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
    use HasTranslations;

    protected $table = 'xtend_quizzes';

    protected $fillable = [
        'handle',
        'name',
        'heading',
        'sub_heading',
        'content',
        'featured_image',
        'question_duration',
        'active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'name' => AsCollection::class,
        'heading' => AsCollection::class,
        'sub_heading' => AsCollection::class,
        'content' => AsCollection::class,
        'active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function newFactory(): QuizFactory
    {
        return QuizFactory::new();
    }

    public function scopeActive($query): Builder
    {
        return $query->where('active', true);
    }

    public function quizQuestions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(QuizUserResponse::class);
    }

    public function prizeTiers(): HasMany
    {
        return $this->hasMany(QuizPrizeTier::class);
    }

    public function winner()
    {
        return $this->hasOne(User::class, 'id', 'winner_user_id');
    }
}

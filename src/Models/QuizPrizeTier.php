<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Base\Traits\HasTranslations;
use Lunar\Models\Discount;
use QuizApp\Database\Factories\QuizPrizeTierFactory;

class QuizPrizeTier extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'xtend_quiz_prize_tiers';

    protected $fillable = [
        'quiz_id',
        'discount_id',
        'handle',
        'name',
        'percentage_off',
        'rules'
    ];

    protected $casts = [
        'name' => AsCollection::class,
        'rules' => 'json',
    ];

    protected static function newFactory(): QuizPrizeTierFactory
    {
        return QuizPrizeTierFactory::new();
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }
}

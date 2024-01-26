<?php

namespace XtendLunar\Addons\QuizApp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QuizApp\Database\Factories\QuizPrizeTiersFactory;

class QuizPrizeTiers extends Model
{
    use HasFactory;

    protected $table = 'xtend_quiz_prize_tiers';

    protected $fillable = [
        'quiz_id',
        'discount_id',
        'name',
        'percentage_off',
        'rules'
    ];

    protected $casts = [
        'rules' => 'json',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // public function discount()
    // {
    //     return $this->belongsTo(Discount::class);
    // }

    protected static function newFactory(): QuizPrizeTiersFactory
    {
        return QuizPrizeTiersFactory::new();
    }
}

<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Product\Database\factories\ProductAnswerFactory;

/**
 * Class ProductAnswer
 * @package Modules\Product\Models
 * @property int $id
 * @property int $product_question_id
 * @property string $text
 * @property string $name
 * @property int $like
 * @property int $dislike
 * @property Carbon|null $date
 * @property-read ProductQuestion $productQuestion
 * @mixin \Eloquent
 * @method static Builder|ProductQuestion newModelQuery()
 * @method static Builder|ProductQuestion newQuery()
 * @method static Builder|ProductQuestion query()
 */
class ProductAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'answered_at' => 'date:Y-m-d',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function (self $productAnswer) {
            $productAnswer->date = $productAnswer->freshTimestamp();
        });
    }

    public function productQuestion(): BelongsTo
    {
        return $this->belongsTo(ProductQuestion::class);
    }

    protected static function newFactory(): ProductAnswerFactory
    {
        return ProductAnswerFactory::new();
    }
}

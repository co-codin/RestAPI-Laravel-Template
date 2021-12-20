<?php

namespace Modules\Product\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Product\Database\factories\ProductQuestionFactory;
use Modules\Product\Enums\ProductQuestionStatus;

/**
 * Class ProductQuestion
 * @package Modules\Product\Models
 * @property int $id
 * @property int $product_id
 * @property int|null $client_id
 * @property int $status
 * @property string $text
 * @property Carbon|null $date
 * @property-read Collection|ProductAnswer[] $productAnswers
 * @property-read Product $product
 * @property-read Client $client
 * @mixin \Eloquent
 * @method static Builder|ProductQuestion newModelQuery()
 * @method static Builder|ProductQuestion newQuery()
 * @method static Builder|ProductQuestion query()
 */
class ProductQuestion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function (self $productQuestion) {
            $productQuestion->date = $productQuestion->freshTimestamp();
        });
    }

    public function productAnswers(): HasMany
    {
        return $this->hasMany(ProductAnswer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function scopePublished($query): void
    {
        $query->where('status', ProductQuestionStatus::APPROVED);
    }

    protected static function newFactory(): ProductQuestionFactory
    {
        return ProductQuestionFactory::new();
    }
}

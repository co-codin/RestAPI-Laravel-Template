<?php

namespace Modules\Product\Models;

use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Currency\Models\Currency;
use Modules\Product\Database\factories\ProductVariationFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class ProductVariation
 * @package Modules\Product\Models
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property int|null $price
 * @property int|null $previous_price
 * @property int|null $currency_id
 * @property bool $is_price_visible
 * @property bool $is_enabled
 * @property int $availability
 * @property int $condition_id
 * @property string|null $stock_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Product $product
 * @property-read Currency $currency
 * @property-read FieldValue $condition
 * @mixin \Eloquent
 * @method static Builder|ProductVariation newModelQuery()
 * @method static Builder|ProductVariation newQuery()
 * @method static Builder|ProductVariation query()
 */
class ProductVariation extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'product_id' => 'integer',
        'price' => 'integer',
        'previous_price' => 'integer',
        'currency_id' => 'integer',
        'is_price_visible' => 'boolean',
        'is_enabled' => 'boolean',
        'availability' => 'integer',
        'options' => 'array',
        'condition' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    protected static function newFactory()
    {
        return ProductVariationFactory::new();
    }

    public function condition()
    {
        return $this->belongsTo(FieldValue::class, 'id', 'condition_id');
    }

    public function getPriceAttribute($value): float|int|null
    {
        return $value ? $value / 100 : null;
    }

    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = $value
            ? $value * 100
            : null;
    }

    public function getPreviousPriceAttribute($value): float|int|null
    {
        return $value ? $value / 100 : null;
    }

    public function setPreviousPriceAttribute($value): void
    {
        $this->attributes['previous_price'] = $value
            ? $value * 100
            : null;
    }
}

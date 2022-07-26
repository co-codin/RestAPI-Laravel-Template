<?php

namespace Modules\Product\Models;

use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Activity\Models\Activity;
use Modules\Currency\Models\Currency;
use Modules\Product\Database\factories\ProductVariationFactory;
use Modules\Product\Models\Pivots\ProductVariationPropertyPivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class ProductVariation
 * @package Modules\Product\Models
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property float|int|null $price
 * @property int|null $price_in_rub
 * @property float|int|null $previous_price
 * @property int|null $currency_id
 * @property bool $is_price_visible
 * @property bool $is_enabled
 * @property int $availability
 * @property int $condition_id
 * @property bool $is_update_from_links
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Product $product
 * @property-read Currency $currency
 * @property-read FieldValue $condition
 * @property-read Collection|VariationLink[] $variationLinks
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
        'condition_id' => 'integer',
        'is_update_from_links' => 'boolean',
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

    public function tapActivity(Activity $activity)
    {
        $activity->parent_subject_type = get_class($this->product);
        $activity->parent_subject_id = $this->product->getKey();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariationProperties(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariationProperty::class, 'product_variation_property')
            ->using(ProductVariationPropertyPivot::class)
            ->withPivot([
                'field_value_ids',
            ]);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function variationLinks(): HasMany
    {
        return $this->hasMany(VariationLink::class);
    }

    protected static function newFactory()
    {
        return ProductVariationFactory::new();
    }

    public function condition()
    {
        return $this->belongsTo(FieldValue::class);
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

    public function getPriceInRubAttribute() : int
    {
        return $this->price ? ceil($this->price * $this->currency->rate) : 0;
    }
}

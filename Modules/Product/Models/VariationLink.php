<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Currency\Models\Currency;
use Modules\Product\Database\factories\VariationLinkFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class VariationLink
 * @package Modules\Product\Models
 * @property int $id
 * @property int $product_variation_id
 * @property string $supplier
 * @property string $key
 * @property boolean $is_default
 * @property array $check
 * @property int $currency_id
 * @property int $price
 * @property int $availability
 * @property Carbon|null $info_updated_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProductVariation $productVariation
 * @property-read Currency $currency
 * @mixin \Eloquent
 * @method static Builder|VariationLink newModelQuery()
 * @method static Builder|VariationLink newQuery()
 * @method static Builder|VariationLink query()
 */
class VariationLink extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'check' => 'array',
        'is_default' => 'boolean'
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

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    protected static function newFactory(): VariationLinkFactory
    {
        return VariationLinkFactory::new();
    }
}

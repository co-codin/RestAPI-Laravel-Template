<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\Database\factories\ProductAnalogFactory;

/**
 * Class ProductAnalog
 * @package Modules\Product\Models
 * @property int $id
 * @property int $product_id
 * @property int $analog_id
 * @property int $position
 * @property-read Collection|Product[] $products
 * @property-read Collection|Product[] $analogs
 * @mixin \Eloquent
 * @method static Builder|ProductQuestion newModelQuery()
 * @method static Builder|ProductQuestion newQuery()
 * @method static Builder|ProductQuestion query()
 */
class ProductAnalog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function analogs(): HasMany
    {
        return $this->hasMany(Product::class, 'id', 'analog_id');
    }

    protected static function newFactory(): ProductAnalogFactory
    {
        return ProductAnalogFactory::new();
    }
}

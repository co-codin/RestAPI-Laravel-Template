<?php


namespace Modules\Product\Models\Pivots;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Product\Models\Product;

/**
 * Class ProductAnalogPivot
 * @package Modules\Product\Models\Pivots
 * @property int $id
 * @property int $product_id
 * @property int $analog_id
 * @property int $position
 * @property-read Collection|Product[] $products
 * @property-read Collection|Product[] $analogs
 */
class ProductAnalogPivot extends Pivot
{
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function analogs(): HasMany
    {
        return $this->hasMany(Product::class, 'id', 'analog_id');
    }
}

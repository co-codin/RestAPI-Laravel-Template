<?php

namespace Modules\Product\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Modules\Product\Database\factories\ProductAnalogFactory;
use Modules\Product\Enums\ProductGroup;

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

    public function scopeOnlyActiveAnalogs(Builder $query): Builder
    {
        return $query->whereExists(function (QueryBuilder $query) {
            $query
                ->select(DB::raw(1))
                ->from('products as p')
                ->whereColumn('p.id', 'product_analog.analog_id')
                ->where('p.status', Status::ACTIVE)
                ->where(function (QueryBuilder $query) {
                    $query
                        ->where('p.group_id', ProductGroup::PRIORITY)
                        ->orWhere('p.group_id', ProductGroup::REORIENTATED);
                });
        });
    }

    protected static function newFactory(): ProductAnalogFactory
    {
        return ProductAnalogFactory::new();
    }
}

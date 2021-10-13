<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Database\factories\SoldProductFactory;
use Modules\Product\Models\Product;

class SoldProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        "id",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected static function newFactory()
    {
        return SoldProductFactory::new();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_enabled', '=', true);
    }
}

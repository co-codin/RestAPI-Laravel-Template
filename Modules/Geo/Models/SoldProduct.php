<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Database\factories\SoldProductFactory;
use Modules\Product\Models\Product;

class SoldProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'product_id',
        'city_id',
        'is_enabled',
        'type',
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
}

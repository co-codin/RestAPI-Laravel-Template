<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
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
        'category_id',
        'type',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id','product_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'id','city_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id','category_id');
    }

    protected static function newFactory()
    {
        return SoldProductFactory::new();
    }
}

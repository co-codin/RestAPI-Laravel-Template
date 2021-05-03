<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Product\Database\factories\ProductFactory;
use Modules\Property\Models\Pivots\PropertyValuePivot;
use Modules\Property\Models\Property;
use Modules\Seo\Models\Seo;

/**
 * Class Product
 * @package Modules\Product\Models
 * @property int|null $id
 * @property string $name
 * @property string $slug
 * @property int $brand_id
 * @property int $status
 * @property boolean $is_in_home
 * @property int|null $warranty
 * @property array|null $documents
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
//        'type' => 'integer',
        'brand_id' => 'integer',
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'warranty' => 'integer',
        'documents' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            ProductCategory::class,
            'product_id',
            'id',
            'id',
            'category_id'
        )
            ->where('product_categories.is_main', '=', true);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category')
            ->withPivot('is_main');
    }

    public function properties()
    {
        return $this
            ->belongsToMany(Property::class, 'property_value')
            ->using(PropertyValuePivot::class)
            ->withPivot([
                'value', 'pretty_key', 'pretty_value', 'is_important', 'important_position', 'important_value'
            ])
            ->whereNotNull('value');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}

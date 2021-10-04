<?php

namespace Modules\Product\Models;

use App\Models\Image;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Product\Database\factories\ProductFactory;
use Modules\Product\Models\Pivots\ProductPropertyPivot;
use Modules\Property\Models\Property;
use Modules\Seo\Models\Seo;
use App\Concerns\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Product
 * @package Modules\Product\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $brand_id
 * @property int $status
 * @property boolean $is_in_home
 * @property int|null $warranty
 * @property boolean $has_test_drive
 * @property string|null $booklet
 * @property string|null $video
 * @property array|null $documents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Brand $brand
 * @property-read Category $category
 * @property-read Seo $seo
 * @property-read Collection|ProductCategory[] $productCategories
 * @property-read Collection|Category[] $categories
 * @property-read Collection|ProductVariation[] $productVariations
 * @property-read Collection|Property[] $properties
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
//        'type' => 'integer',
        'brand_id' => 'integer',
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'warranty' => 'integer',
        'documents' => 'array',
        'has_test_drive' => 'boolean',
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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    /**
     * Get the productCategories for the Product.
     */
    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id');
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
            ->where('product_category.is_main', '=', true);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category')
            ->withPivot('is_main');
    }

    public function properties()
    {
        return $this
            ->belongsToMany(Property::class, 'product_property')
            ->using(ProductPropertyPivot::class)
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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function toSearchArray()
    {
        return ['name' => $this->name];
    }
}

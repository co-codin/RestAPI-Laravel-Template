<?php

namespace Modules\Product\Models;

use App\Concerns\IsActive;
use App\Models\FieldValue;
use App\Models\Image;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Product\Database\factories\ProductFactory;
use Modules\Product\Models\Pivots\ProductPropertyPivot;
use Modules\Property\Models\Property;
use Modules\Review\Models\ProductReview;
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
 * @property string|null $image
 * @property boolean $is_in_home
 * @property int|null $warranty
 * @property string|null $short_description
 * @property string|null $full_description
 * @property boolean $has_test_drive
 * @property string|null $booklet
 * @property string|null $video
 * @property string $siteUrl
 * @property array|null $documents
 * @property int|null $group_id
 * @property int|null $stock_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property float $rating
 * @property-read Brand $brand
 * @property-read FieldValue $stockType
 * @property-read Category $category
 * @property-read Seo $seo
 * @property-read Collection|ProductReview[] $productReviews
 * @property-read Collection|ProductQuestion[] $productQuestions
 * @property-read Collection|ProductCategory[] $productCategories
 * @property-read Collection|Category[] $categories
 * @property-read Collection|ProductVariation[] $productVariations
 * @property-read ProductVariation|null $mainVariation
 * @property-read Collection|Property[] $properties
 * @property-read Collection|Image[] $images
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory, IsActive, SoftDeletes, Searchable, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
//        'type' => 'integer',
        'brand_id' => 'integer',
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'warranty' => 'integer',
        'documents' => 'array',
        'has_test_drive' => 'boolean',
        'stock_type_id' => 'integer',
        'benefits' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function getRatingAttribute(): float
    {
        $rating = $this->productReviews
            ->avg(fn(ProductReview $productReview) => $productReview->ratings_avg);

        return !is_null($rating) ? round($rating) : 0;
    }

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

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function productQuestions(): HasMany
    {
        return $this->hasMany(ProductQuestion::class);
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
                'field_value_ids', 'value', 'pretty_key', 'pretty_value', 'is_important', 'important_position', 'important_value'
            ]);
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
        return $this->morphMany(Image::class, 'imageable')
            ->orderBy('position');
    }

    public function mainVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function getPriceAttribute($value): float|int|null
    {
        return $value ? $value / 10000 : null;
    }

    public function scopeWithPrice($query)
    {
        $query->addSelect(['price' => ProductVariation::selectRaw('rate * price')
            ->whereColumn('product_id', 'products.id')
            ->join('currencies', 'currency_id', 'currencies.id')
            ->orderByRaw('rate * price ASC')
            ->take(1),
        ]);
    }

    public function scopeWithMainVariation($query)
    {
        $query->addSelect(['main_variation_id' => ProductVariation::select('product_variations.id')
            ->whereColumn('product_id', 'products.id')
            ->where('is_enabled', true)
            ->leftJoin('currencies', 'currency_id', 'currencies.id')
            ->orderByRaw('rate * price ASC')
            ->take(1),
        ])->with('mainVariation');
    }

    public function scopeHasActiveVariation(Builder $query)
    {
        return $query->havingRaw('main_variation_id is not null');
    }

    public function stockType()
    {
        return $this->belongsTo(FieldValue::class);
    }

    public function getSiteUrlAttribute(): string
    {
        return config('app.site_url') . "/product/{$this->slug}/{$this->id}";
    }
}

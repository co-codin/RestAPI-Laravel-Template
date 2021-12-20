<?php

namespace Modules\Category\Models;

use App\Concerns\IsActive;
use App\Concerns\Searchable;
use App\Vendor\NestedSet\AncestorsRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\Collection as CollectionNestedset;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Cabinet\Models\Cabinet;
use Modules\Category\Database\factories\CategoryFactory;
use Modules\Filter\Models\Filter;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;
use Modules\Seo\Enums\SeoType;
use Modules\Seo\Models\Seo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Category
 * @package Modules\Category\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $_lft
 * @property int|null $_rgt
 * @property int|null $parent_id
 * @property string|null $product_name
 * @property string $full_description
 * @property int $status
 * @property boolean $is_in_home
 * @property string|null $image
 * @property array|null $review_ratings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Category|null $parent
 * @property-read Seo|null $seo
 * @property-read Category[]|CollectionNestedset $children
 * @property-read Category[]|CollectionNestedset $ancestors
 * @property-read Category[]|CollectionNestedset $descendants
 * @property-read Collection|ProductCategory[] $productCategories
 * @property-read Collection|Product[] $products
 * @mixin \Eloquent
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 */
class Category extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, IsActive, LogsActivity, Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'review_ratings' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'full_description',
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category')
            ->withPivot('is_main');
    }

    public function cabinets()
    {
        return $this->belongsToMany(Cabinet::class, 'cabinet_category')
            ->withPivot([
                'name',
                'count',
                'price',
                'position',
            ]);
    }

    /**
     * Get the productCategories for the Category.
     */
    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class, 'category_id', 'id');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable')
            ->where('type', SeoType::Self);
    }

    public function seoCategoryProducts(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable')
            ->where('type', SeoType::CategoryProducts);
    }

    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

    public function scopeIsRoot(Builder $query): Builder
    {
        return $query->whereNull($this->getParentIdName());
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function ancestors()
    {
        return new AncestorsRelation($this->newQuery(), $this);
    }
}

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
 * @property Category|null $parent
 * @property Category[]|CollectionNestedset $children
 * @property Category[]|CollectionNestedset $ancestors
 * @property Category[]|CollectionNestedset $descendants
 * @property Seo|null $seo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
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

    public function cabinets()
    {
        return $this->hasMany(Cabinet::class);
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

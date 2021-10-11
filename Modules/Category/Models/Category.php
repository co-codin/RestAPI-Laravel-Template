<?php

namespace Modules\Category\Models;

use App\Concerns\IsActive;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\NodeTrait;
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
 * @property string|null $product_name
 * @property string $full_description
 * @property int $status
 * @property boolean $is_hidden_in_parents
 * @property boolean $is_in_home
 * @property string|null $image
 * @property Category|null $parent
 * @property Category[]|Collection $ancestors
 * @property Category[]|Collection $descendants
 * @property Seo|null $seo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Product[] $productCategories
 * @mixin \Eloquent
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 */
class Category extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, IsActive, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_hidden_in_parents' => 'boolean',
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
}

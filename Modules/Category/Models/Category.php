<?php

namespace Modules\Category\Models;

use App\Traits\IsActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Category\Database\factories\CategoryFactory;
use Modules\Filter\Models\Filter;
use Modules\Property\Models\Property;
use Modules\Seo\Models\Seo;

/**
 * Class Category
 * @package Modules\Category\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $product_name
 * @property string $full_description
 * @property int $status
 * @property boolean $is_hidden_in_parents
 * @property boolean $is_in_home
 * @property string $image
 * @property Category|null $parent
 * @property Category[] $ancestors
 * @property Category[] $descendants
 * @property Seo|null $seo
 */
class Category extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, IsActive;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_hidden_in_parents' => 'boolean',
        'is_in_home' => 'boolean',
    ];

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

    public function properties()
    {
        return $this->belongsToMany(
            Property::class,
            'property_category',
            'category_id',
            'property_id',
        )->withPivot(['section', 'position']);
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}

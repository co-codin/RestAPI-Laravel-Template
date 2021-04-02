<?php

namespace Modules\Category\Models;

use App\Traits\IsActive;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Category\Database\factories\CategoryFactory;
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
 * @property array $short_properties
 * @property Category|null $parent
 * @property Category[] $ancestors
 * @property Category[] $descendants
 * @property Seo|null $seo
 */
class Category extends Model
{
    use HasFactory, Sluggable, NodeTrait, SoftDeletes, IsActive {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $guarded = ['id'];

    protected $casts = [
        'short_properties' => 'array',
        'status' => 'integer',
        'is_hidden_in_parents' => 'boolean',
        'is_in_home' => 'boolean',
    ];

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}

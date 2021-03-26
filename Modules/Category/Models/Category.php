<?php

namespace Modules\Category\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Category\Database\factories\CategoryFactory;

class Category extends Model
{
    use HasFactory, Sluggable, NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $guarded = ['id'];

    protected $casts = [
        'links' => 'array',
        'short_properties' => 'array',
        'status' => 'integer',
        'hide_in_parents' => 'integer',
        'is_in_home' => 'boolean',
        'position' => 'integer',
        'new_structure' => 'integer',
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

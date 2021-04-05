<?php

namespace Modules\Page\Models;

use App\Traits\IsActive;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Page\Database\factories\PageFactory;
use Modules\Seo\Models\Seo;

class Page extends Model
{
    use HasFactory, Sluggable, NodeTrait, SoftDeletes, IsActive {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function newFactory()
    {
        return PageFactory::new();
    }
}

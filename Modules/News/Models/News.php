<?php

namespace Modules\News\Models;

use App\Concerns\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\Database\factories\NewsFactory;
use Modules\Seo\Models\Seo;

/**
 * Class News
 * @package Modules\News\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property boolean $is_in_home
 * @property ?Seo $seo
 */
class News extends Model
{
    use HasFactory, SoftDeletes, Sluggable, IsActive;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'published_at' => 'datetime:Y-m-d',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function newFactory()
    {
        return NewsFactory::new();
    }
}

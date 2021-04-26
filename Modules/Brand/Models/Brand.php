<?php

namespace Modules\Brand\Models;

use App\Concerns\IsActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Seo\Models\Seo;

/**
 * Class Brand
 * @package Modules\Brand\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property boolean $is_in_home
 * @property int $status
 * @property string|null $short_description
 * @property string|null $full_description
 * @property string|null $country
 * @property int|null $position
 * @property string|null $website
 * @property int|null Seo $seo
 */
class Brand extends Model
{
    use HasFactory, Sluggable, IsActive, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'position' => 'integer',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}

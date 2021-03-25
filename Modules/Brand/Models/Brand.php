<?php

namespace Modules\Brand\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * Class Brand
 * @package Modules\Brand\Models
 * @property int|null $id
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
 */
class Brand extends Model
{
    use HasFactory, Sluggable;

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

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', Status::ACTIVE);
    }

    protected static function newFactory()
    {
        return BrandFactory::new();
    }
}

<?php

namespace Modules\Brand\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id', 'slug'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'image' => 'string',
        'short_description' => 'string',
        'country' => 'string',
        'website' => 'string',
        'full_description' => 'string',
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'position' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', 1);
    }

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}

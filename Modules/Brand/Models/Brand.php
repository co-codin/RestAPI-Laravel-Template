<?php

namespace Modules\Brand\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'position' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', Status::ACTIVE);
    }

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
}

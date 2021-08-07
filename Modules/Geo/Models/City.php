<?php

namespace Modules\Geo\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use \Modules\Geo\Database\factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'coordinate' => 'object',
    ];

    public function sluggable(): array
    {
        return [
            'city_slug' => [
                'source' => 'city_name'
            ]
        ];
    }

    public function orderPoints()
    {
        return $this->hasMany(OrderPoint::class);
    }

    protected static function newFactory()
    {
        return CityFactory::new();
    }
}

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
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function orderPoints()
    {
        return $this->hasMany(OrderPoint::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    protected static function newFactory()
    {
        return CityFactory::new();
    }
}

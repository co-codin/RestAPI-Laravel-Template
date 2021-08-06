<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use \Modules\Geo\Database\factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'coordinate' => 'object',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'city_name'
            ]
        ];
    }

    protected static function newFactory()
    {
        return CityFactory::new();
    }
}

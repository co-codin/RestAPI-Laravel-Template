<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use \Modules\Geo\Database\factories\GeoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Geo extends Model
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
        return GeoFactory::new();
    }
}

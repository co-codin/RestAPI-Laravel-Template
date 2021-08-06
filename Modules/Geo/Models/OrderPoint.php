<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Database\factories\OrderPointFactory;

class OrderPoint extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'coordinate' => 'object',
        'timetable' => 'object',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected static function newFactory()
    {
        return OrderPointFactory::new();
    }
}

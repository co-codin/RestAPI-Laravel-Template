<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Enums\District;
use Modules\Geo\Database\factories\RegionFactory;

/**
 * @property-read City|Collection $cities
 */
class Region extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected static function newFactory()
    {
        return RegionFactory::new();
    }

    public function getFederalDistrictNameAttribute()
    {
        return District::getDescription($this->attributes['federal_district']);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}

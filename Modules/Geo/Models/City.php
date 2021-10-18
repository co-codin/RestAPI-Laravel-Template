<?php

namespace Modules\Geo\Models;

use App\Concerns\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Enums\District;
use \Modules\Geo\Database\factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, Sluggable, IsActive;

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

    public function soldProducts()
    {
        return $this->hasMany(SoldProduct::class);
    }

    public function scopeWithSoldProducts(Builder $query): Builder
    {
        return $query->whereHas('soldProducts');
    }

    public function scopeSortBySoldProducts(Builder $query): Builder
    {
        return $query->whereHas('soldProducts')->withCount('soldProducts')->orderBy('sold_products_count', 'desc');
    }

    public function scopeWithOrderPoints(Builder $query): Builder
    {
        return $query->whereHas('orderPoints');
    }

    protected static function newFactory()
    {
        return CityFactory::new();
    }

    public function getFederalDistrictNameAttribute()
    {
        return District::getDescription($this->attributes['federal_district']);
    }
}

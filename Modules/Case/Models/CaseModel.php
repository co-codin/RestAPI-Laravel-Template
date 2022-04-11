<?php

namespace Modules\Case\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Case\Database\factories\CaseFactory;
use Modules\Geo\Models\City;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date:Y-m-d',
        'is_enabled' => 'boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeIsEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', '=', true);
    }

    protected static function newFactory()
    {
        return CaseFactory::new();
    }
}

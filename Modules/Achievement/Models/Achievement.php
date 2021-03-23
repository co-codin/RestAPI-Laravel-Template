<?php

namespace Modules\Achievement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Achievement\Database\factories\AchievementFactory;

class Achievement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'is_enabled' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_enabled', '=', true);
    }

    protected static function newFactory()
    {
        return AchievementFactory::new();
    }
}

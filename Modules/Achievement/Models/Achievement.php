<?php

namespace Modules\Achievement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Achievement\Enums\AchievementStatus;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'position',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', AchievementStatus::OPEN);
    }

    protected static function newFactory()
    {
        return \Modules\Achievement\Database\factories\AchievementFactory::new();
    }
}

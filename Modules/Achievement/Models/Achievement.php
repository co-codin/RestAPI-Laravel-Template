<?php

namespace Modules\Achievement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Achievement\Database\factories\AchievementFactory;

/**
 * Class Achievement
 * @package Modules\Achievement\Models
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property boolean $is_enabled
 * @property int $position
 */
class Achievement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
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

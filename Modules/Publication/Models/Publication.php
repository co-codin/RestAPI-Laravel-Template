<?php

namespace Modules\Publication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Publication\Database\factories\PublicationFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Publication
 * @package Modules\Publication\Models
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $source
 * @property string|null $logo
 * @property bool $is_enabled
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|Publication newModelQuery()
 * @method static Builder|Publication newQuery()
 * @method static Builder|Publication query()
 */
class Publication extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date:Y-m-d',
        'is_enabled' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
    }

    public function scopeIsEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', '=', true);
    }

    protected static function newFactory()
    {
        return PublicationFactory::new();
    }
}

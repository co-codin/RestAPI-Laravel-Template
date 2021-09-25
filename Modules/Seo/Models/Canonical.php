<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Seo\Database\factories\CanonicalFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * This is the model class for table "canonicals".
 *
 * Modules\Seo\Models\Canonical
 *
 * @property int $id
 * @property string $url
 * @property string $canonical
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|Canonical newModelQuery()
 * @method static Builder|Canonical newQuery()
 * @method static Builder|Canonical query()
 */
class Canonical extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'url',
        'canonical',
        'assigned_by_id',
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

    protected static function newFactory()
    {
        return CanonicalFactory::new();
    }
}

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
 * Modules\Seo\Models\CanonicalEntity
 *
 * @property int $id
 * @property string $url
 * @property string $canonical
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|CanonicalEntity newModelQuery()
 * @method static Builder|CanonicalEntity newQuery()
 * @method static Builder|CanonicalEntity query()
 */
class CanonicalEntity extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'canonicals';

    protected $fillable = [
        'url',
        'canonical',
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

<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Seo\Database\factories\SeoFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Seo
 * @package Modules\Seo\Models
 * @property string $seoable_type
 * @property int $seoable_id
 * @property boolean $is_enabled
 * @property string|null $title
 * @property string|null $description
 * @property string|null $h1
 * @property array|null $meta_tags
// * @property integer $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|Seo newModelQuery()
 * @method static Builder|Seo newQuery()
 * @method static Builder|Seo query()
 */
class Seo extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected $table = 'seo';

    protected $casts = [
        'is_enabled' => 'boolean',
        'type' => 'integer',
        'meta_tags' => 'array',
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
        return SeoFactory::new();
    }
}

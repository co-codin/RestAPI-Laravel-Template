<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Seo\Database\factories\SeoRuleFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SeoRule
 * @package Modules\Seo\Models
 * @property int $id
 * @property string $name
 * @property string $url
 * @property Seo $seo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|SeoRule newModelQuery()
 * @method static Builder|SeoRule newQuery()
 * @method static Builder|SeoRule query()
 */
class SeoRule extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return SeoRuleFactory::new();
    }

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

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}

<?php

namespace Modules\Currency\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Currency\Database\factories\CurrencyFactory;
use Spatie\Activitylog\LogOptions;

/**
 * Class Currency
 * @package Modules\Currency\Models
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property int|float $rate
 * @property boolean $is_main
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin \Eloquent
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 */
class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getRateAttribute($value)
    {
        return $value / 100;
    }

    public function setRateAttribute($value)
    {
        $this->attributes['rate'] = $value * 100;
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

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }
}

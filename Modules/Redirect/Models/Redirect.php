<?php

namespace Modules\Redirect\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Redirect\Database\factories\RedirectFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Redirect
 * @package Modules\Redirect\Models
 * @property int $id
 * @property string $source
 * @property string $destination
 * @property int $code [default = 301]
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|Redirect newModelQuery()
 * @method static Builder|Redirect newQuery()
 * @method static Builder|Redirect query()
 */
class Redirect extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

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
        return RedirectFactory::new();
    }
}

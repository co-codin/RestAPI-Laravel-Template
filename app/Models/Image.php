<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Image
 * @package App\Entities\Image
 *
 * @property int $id
 * @property string $imageable_type
 * @property int $imageable_id
 * @property string $image
 * @property string|null $position
 * @property string|null $caption
 * @property-read Model|\Eloquent $imageable
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static Builder|Image query()
 * @method static Builder|Image whereCaption($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereImageableId($value)
 * @method static Builder|Image whereImageableType($value)
 * @method static Builder|Image wherePosition($value)
 * @method static Builder|Image whereImage($value)
 */
class Image extends Model
{
    use LogsActivity;

    protected $guarded = ['id'];

    public function imageable()
    {
        return $this->morphTo();
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

    public function tapActivity(Activity $activity)
    {
        $activity->parent_subject_type = $this->imageable_type;
        $activity->parent_subject_id = $this->imageable_id;
    }
}

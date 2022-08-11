<?php

namespace Modules\Activity\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Customer\Models\CustomerReview;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

/**
 * Class Activity
 * @package Modules\Activity\Models
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property string|null $event
 * @property int|null $subject_id
 * @property string|null $parent_subject_type
 * @property int|null $parent_subject_id
 * @property string|null $causer_type
 * @property int|null $causer_id
 * @property SupportCollection|null $properties
 * @property string|null $batch_uuid [char[36]]
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|CustomerReview newModelQuery()
 * @method static Builder|CustomerReview newQuery()
 * @method static Builder|CustomerReview query()
 */
class Activity extends SpatieActivity
{
    public function parentSubject(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }
}

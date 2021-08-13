<?php


namespace Modules\Activity\Repositories;


use Illuminate\Support\Collection as SupportCollection;
use Modules\Activity\Models\Activity;
use Modules\Activity\Repositories\Criteria\ActivityRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ActivityRepository
 * @package Modules\Activity\Repositories
 * @property Activity $model
 */
class ActivityRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Activity::class;
    }

    public function boot()
    {
        $this->pushCriteria(ActivityRequestCriteria::class);
    }
}

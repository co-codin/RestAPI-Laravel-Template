<?php


namespace Modules\Activity\Repositories;


use Illuminate\Support\Collection as SupportCollection;
use Modules\Activity\Models\Activity;
use Modules\Activity\Repositories\Criteria\ActivityRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ActivityRepository extends BaseRepository
{
    public function model()
    {
        return Activity::class;
    }

    public function boot()
    {
        $this->pushCriteria(ActivityRequestCriteria::class);
    }
}

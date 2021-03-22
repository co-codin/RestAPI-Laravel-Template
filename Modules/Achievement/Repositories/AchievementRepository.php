<?php

namespace Modules\Achievement\Repositories;

use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\Criteria\AchievementRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class AchievementRepository extends BaseRepository
{
    public function boot()
    {
        $this->pushCriteria(AchievementRequestCriteria::class);
    }

    public function model()
    {
        return Achievement::class;
    }
}

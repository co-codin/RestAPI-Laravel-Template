<?php

namespace Modules\Achievement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\Criteria\AchievementRequestCriteria;

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

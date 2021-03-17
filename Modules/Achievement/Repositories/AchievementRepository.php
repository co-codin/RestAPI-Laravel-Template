<?php

namespace Modules\Achievement\Repositories;

use Modules\Achievement\Models\Achievement;
use Prettus\Repository\Eloquent\BaseRepository;

class AchievementRepository extends BaseRepository
{
    public function model()
    {
        return Achievement::class;
    }
}

<?php

namespace Modules\Achievement\Repositories\Criteria;

use Modules\Achievement\Enums\AchievementStatus;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ActiveAchievementCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('status', AchievementStatus::OPEN);
    }
}

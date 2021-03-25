<?php

namespace App\Repositories\Criteria;

use App\Enums\Status;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ActiveStatusCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('status', Status::ACTIVE);
    }
}

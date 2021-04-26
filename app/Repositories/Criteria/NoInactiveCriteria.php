<?php

namespace App\Repositories\Criteria;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class NoInactiveCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('status', '!=', Status::INACTIVE);
    }
}

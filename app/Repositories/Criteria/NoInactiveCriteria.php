<?php

namespace App\Repositories\Criteria;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NoInactiveCriteria.
 *
 * @package namespace App\Criteria;
 */
class NoInactiveCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string|Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('status', '!=', Status::INACTIVE);
    }
}

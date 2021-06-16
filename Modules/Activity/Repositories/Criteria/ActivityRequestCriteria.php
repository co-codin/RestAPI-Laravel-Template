<?php

namespace Modules\Activity\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Http\Builders\ActivityBuilder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ActivityRequestCriteria.
 *
 * @package Modules\Activity\Repositories\Criteria;
 */
class ActivityRequestCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return (new ActivityBuilder())->builder($model);
    }
}

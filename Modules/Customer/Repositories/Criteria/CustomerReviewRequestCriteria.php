<?php

namespace Modules\Customer\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Http\Builders\CustomerReviewBuilder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CustomerReviewRequestCriteria.
 *
 * @package Modules\Customer\Repositories\Criteria;
 */
class CustomerReviewRequestCriteria implements CriteriaInterface
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
        return (new CustomerReviewBuilder())->builder($model);
    }
}

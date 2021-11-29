<?php

namespace Modules\Review\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Review\Http\Builders\ProductReviewBuilder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductReviewRequestCriteria implements CriteriaInterface
{
    /**
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return (new ProductReviewBuilder())->builder($model);
    }
}

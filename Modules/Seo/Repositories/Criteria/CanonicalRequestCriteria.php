<?php

namespace Modules\Seo\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Seo\Http\Builders\CanonicalBuilder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CanonicalRequestCriteria.
 *
 * @package Modules\Seo\Repositories\Admin\Criteria;
 */
class CanonicalRequestCriteria implements CriteriaInterface
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
        return (new CanonicalBuilder())->builder($model);
    }
}

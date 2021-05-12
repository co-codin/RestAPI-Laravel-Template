<?php

namespace Modules\Seo\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SeoRuleEnabledCriteria.
 *
 * @package namespace Modules\Seo\Repositories\Criteria;
 */
class SeoRuleEnabledCriteria implements CriteriaInterface
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
        return $model->with(['seo' => function ($query) {
                $query->where('is_enabled', true);
            }]);
    }
}

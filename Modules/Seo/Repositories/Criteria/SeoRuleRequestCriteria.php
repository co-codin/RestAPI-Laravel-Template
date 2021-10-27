<?php

namespace Modules\Seo\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SeoRuleRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'name', 'url', 'text', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('url'),
                AllowedFilter::exact('seo.is_enabled'),
                AllowedFilter::custom('live', new LiveFilter([
                    'name' => 'like',
                    'url' => 'like',
                ])),
            ])
            ->allowedIncludes('seo')
            ->allowedSorts('id', 'name', 'url', 'created_at', 'updated_at');
    }
}

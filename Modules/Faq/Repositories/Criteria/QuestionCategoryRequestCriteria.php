<?php


namespace Modules\Faq\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class QuestionCategoryRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'name', 'slug', 'status', 'position', 'created_at', 'updated_at', 'deleted_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('position'),
            ])
            ->allowedSorts('id', 'name', 'slug', 'status', 'position', 'created_at', 'updated_at', 'deleted_at')
            ->allowedIncludes('questions')
            ;
    }
}

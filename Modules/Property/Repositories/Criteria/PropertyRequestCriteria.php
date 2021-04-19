<?php


namespace Modules\Property\Repositories\Criteria;


use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PropertyRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                ['id', 'name', 'type', 'description', 'options', 'is_hidden_from_product', 'is_hidden_from_comparison', 'created_at', 'updated_at'],
                CategoryRequestCriteria::allowedCategoryFields('categories')
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('categories.id'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('is_hidden_from_product'),
                AllowedFilter::exact('is_hidden_from_comparison'),
            ])
            ->allowedIncludes('categories')
            ->allowedSorts('name')
            ;
    }
}

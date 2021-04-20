<?php


namespace Modules\Filter\Repositories\Criteria;


use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilterRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('position')
            ->allowedFields(array_merge(
                ['id', 'name', 'type', 'slug', 'category_id', 'description', 'is_enabled', 'is_default', 'property_id', 'options'],
                CategoryRequestCriteria::allowedCategoryFields('category')
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('is_enabled'),
                AllowedFilter::exact('is_default'),
                AllowedFilter::exact('property_id'),
                AllowedFilter::exact('options->field'),
            ])
            ->allowedIncludes('category')
            ->allowedSorts('name', 'slug')
            ;
    }
}

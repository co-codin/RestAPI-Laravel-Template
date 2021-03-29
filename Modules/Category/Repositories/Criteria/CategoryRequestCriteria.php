<?php

namespace Modules\Category\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model::query())
            ->defaultSort('id')
            ->allowedFields([
                'id', 'name', 'slug', 'product_name', 'full_description', 'image',
                'status', 'is_hidden_in_parents', 'is_in_home', 'parent_id', 'short_properties',
                'created_at', 'updated_at', 'deleted_at',

            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
                AllowedFilter::partial('product_name'),
                AllowedFilter::partial('full_description'),
                AllowedFilter::partial('short_properties'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('is_hidden_in_parents'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('parent_id'),
            ])
            ->allowedIncludes(['trashed', 'parent', 'ancestors', 'descendants'])
            ->allowedSorts('id', 'name', 'slug', 'product_name', '_lft')
            ;
    }
}

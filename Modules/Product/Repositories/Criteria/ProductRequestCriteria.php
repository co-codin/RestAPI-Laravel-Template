<?php


namespace Modules\Product\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'name', 'image', 'position', 'is_enabled', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('slug'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('brand_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('warranty'),
                AllowedFilter::partial('short_description'),
                AllowedFilter::partial('full_description'),

                AllowedFilter::trashed(),

                AllowedFilter::exact('categories.id'),

                AllowedFilter::exact('productVariations.id'),
                AllowedFilter::partial('productVariations.name'),
                AllowedFilter::exact('productVariations.is_price_visible'),
                AllowedFilter::exact('productVariations.is_enabled'),
                AllowedFilter::exact('productVariations.currency_id'),
                AllowedFilter::exact('productVariations.price'),
                AllowedFilter::exact('productVariations.availability'),
                AllowedFilter::exact('productVariations.previous_price'),
            ])
            ->allowedIncludes(['brand', 'productVariations', 'properties', 'category', 'categories', 'seo'])
            ->allowedSorts('id', 'name', 'warranty', 'created_at', 'updated_at', 'deleted_at')
            ;
    }
}

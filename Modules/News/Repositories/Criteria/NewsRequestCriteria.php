<?php


namespace Modules\News\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class NewsRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('id')
            ->allowedFields([
                'id', 'name', 'slug', 'short_description', 'full_description',
                'status', 'image', 'is_in_home', 'published_at',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('image'),
                AllowedFilter::partial('website'),
                AllowedFilter::exact('country'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('position'),
                AllowedFilter::trashed(),
            ])
            ->allowedIncludes('seo')
            ->allowedSorts([
                'id', 'name', 'slug', 'short_description', 'full_description',
                'status', 'image', 'is_in_home', 'published_at',
            ]);
    }
}

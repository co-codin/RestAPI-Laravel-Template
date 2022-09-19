<?php


namespace Modules\Case\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CaseRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'name', 'slug', 'image', 'images', 'city_id', 'status', 'short_description',
                'full_description', 'summary', 'note', 'created_at', 'updated_at',
                'released_year', 'released_quarter', 'body',
            ])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'slug' => 'like',
                    'summary' => 'like',
                    'note' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('summary'),
                AllowedFilter::partial('body'),
                AllowedFilter::partial('note'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('released_year'),
                AllowedFilter::exact('released_quarter'),
            ])
            ->allowedSorts(
                'id', 'name', 'slug', 'image', 'images', 'city_id', 'status', 'short_description', 'full_description',
                'summary', 'note', 'created_at', 'updated_at', 'released_year', 'released_quarter',
            )
            ->allowedIncludes('city', 'products', 'seo', 'images')
            ;
    }
}

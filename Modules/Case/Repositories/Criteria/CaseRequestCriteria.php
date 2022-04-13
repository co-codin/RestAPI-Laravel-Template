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
            ->allowedFields(['id', 'name', 'slug', 'image', 'city_id', 'status', 'short_description', 'full_description', 'published_at', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'slug' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts('id', 'name', 'slug', 'image', 'city_id', 'status', 'short_description', 'full_description', 'published_at', 'created_at', 'updated_at')
            ->allowedIncludes('city')
            ;
    }
}

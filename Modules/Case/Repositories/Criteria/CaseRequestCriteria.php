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
            ->allowedFields(['id', 'name', 'image', 'city_id', 'is_enabled', 'short_description', 'full_description', 'published_at', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('is_enabled'),
            ])
            ->allowedSorts('id', 'name', 'image', 'city_id', 'is_enabled', 'short_description', 'full_description', 'published_at', 'created_at', 'updated_at')
            ;
    }
}

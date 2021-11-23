<?php


namespace Modules\Publication\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PublicationRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'name', 'url', 'source', 'logo', 'position', 'is_enabled', 'published_at', 'created_at'])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'url' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('url'),
                AllowedFilter::exact('logo'),
                AllowedFilter::exact('is_enabled'),
            ])
            ->allowedSorts('id', 'name', 'logo', 'position', 'is_enabled', 'published_at', 'created_at', 'updated_at')
            ;
    }
}

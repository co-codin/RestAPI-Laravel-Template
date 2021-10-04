<?php


namespace App\Repositories\Criteria;


use App\Filters\ToggleFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FieldValueRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->allowedFields([
                'id',
                'value',
                'slug',
                'created_at',
                'updated_at',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('slug'),
                AllowedFilter::partial('value'),
            ])
            ->allowedSorts([
                'id', 'value', 'slug', 'created_at', 'updated_at',
            ]);
    }
}

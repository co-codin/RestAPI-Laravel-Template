<?php


namespace App\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use App\Http\Filters\PartialRightFilter;
use App\Http\Sorts\FieldLength;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
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
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'value' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('slug'),
                AllowedFilter::custom('value', new PartialRightFilter),
            ])
            ->allowedSorts([
                'id',
                'value', 'slug', 'created_at', 'updated_at',
                AllowedSort::custom('valueLength', new FieldLength, 'value')
            ]);
    }
}

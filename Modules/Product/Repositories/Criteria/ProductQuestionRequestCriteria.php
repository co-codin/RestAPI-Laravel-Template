<?php

namespace Modules\Product\Repositories\Criteria;

use App\Http\Filters\DateFilter;
use App\Http\Filters\LiveFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ProductQuestionRequestCriteria implements CriteriaInterface
{
    /**
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedProductQuestionFields(),
                ProductRequestCriteria::allowedProductFields(),
            ))
            ->allowedFilters([
                'text',
                'live' => AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                ])),
                'id' => AllowedFilter::exact('id'),
                'product_id' => AllowedFilter::exact('product_id'),
                'client_id' => AllowedFilter::exact('client_id'),
                'status' => AllowedFilter::exact('status'),
                'date' => AllowedFilter::custom('date', new DateFilter(), 'date'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'product_id',
                'client_id',
                'status',
                'text',
                'date',
            ])
            ->allowedIncludes([
                'product',
                'product.brand',
                'client',
                'productAnswers',
                AllowedInclude::count('productAnswersCount'),
            ]);
    }

    public static function allowedProductQuestionFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_id',
            'client_id',
            'status',
            'text',
            'date',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}

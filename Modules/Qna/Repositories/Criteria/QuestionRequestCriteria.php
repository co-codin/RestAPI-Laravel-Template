<?php

namespace Modules\Qna\Repositories\Criteria;

use App\Http\Filters\DateFilter;
use App\Http\Filters\LiveFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class QuestionRequestCriteria implements CriteriaInterface
{
    /**
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
//        return (new QuestionBuilder())->builder($model);
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedQuestionFields(),
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
                'created_at' => AllowedFilter::custom('created_at', new DateFilter(), 'created_at'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'product_id',
                'client_id',
                'status',
                'text',
                'created_at',
            ])
            ->allowedIncludes([
                'product',
                'product.brand',
                'client',
                'answers',
                AllowedInclude::count('questionsCount'),
            ]);
    }

    public static function allowedQuestionFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_id',
            'client_id',
            'status',
            'text',
            'created_at',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}

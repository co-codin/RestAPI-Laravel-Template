<?php

namespace Modules\Review\Repositories\Criteria;

use App\Http\Filters\DateFilter;
use App\Http\Filters\LiveFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ProductReviewRequestCriteria implements CriteriaInterface
{
    /**
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
//        return (new ProductReviewBuilder())->builder($model);
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedProductReviewFields(),
                ProductRequestCriteria::allowedProductFields(),
                BrandRequestCriteria::allowedBrandFields('products'),
            ))
            ->allowedFilters([
                'advantages',
                'disadvantages',
                'comment',
                'live' => AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                ])),
                'id' => AllowedFilter::exact('id'),
                'product_id' => AllowedFilter::exact('product_id'),
                'client_id' => AllowedFilter::exact('client_id'),
                'experience' => AllowedFilter::exact('experience'),
                'status' => AllowedFilter::exact('status'),
                'is_confirmed' => AllowedFilter::exact('is_confirmed'),
                'like' => AllowedFilter::exact('like'),
                'dislike' => AllowedFilter::exact('dislike'),
                'created_at' => AllowedFilter::custom('created_at', new DateFilter(), 'created_at'),
                'updated_at' => AllowedFilter::custom('created_at', new DateFilter(), 'updated_at'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'product_id',
                'client_id',
                'experience',
                'status',
                'is_confirmed',
                'like',
                'dislike',
            ])
            ->allowedIncludes([
                'product',
                'client',
                AllowedInclude::count('productReviewsCount'),
            ]);
    }

    public static function allowedProductReviewFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_id',
            'client_id',
            'experience',
            'advantages',
            'disadvantages',
            'comment',
            'status',
            'is_confirmed',
            'ratings',
            'like',
            'dislike',
            'created_at',
            'updated_at'
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}

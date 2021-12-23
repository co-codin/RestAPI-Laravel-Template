<?php

namespace Modules\Product\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductAnalogRequestCriteria implements CriteriaInterface
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
            ->allowedFields(self::allowedProductAnalogFields())
            ->allowedFilters([
                'product_id' => AllowedFilter::exact('product_id'),
                'analog_id' => AllowedFilter::exact('analog_id'),
                'position' => AllowedFilter::exact('position'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'product_id',
                'analog_id',
                'position',
            ])
            ->allowedIncludes([
                'product', 'analogs',
            ]);
    }

    public static function allowedProductAnalogFields($prefix = null): array
    {
        $fields = [
            'product_id',
            'analog_id',
            'position',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}

<?php

namespace Modules\Product\Repositories\Criteria;

use App\Http\Filters\DateFilter;
use App\Http\Filters\LiveFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VariationLinkRequestCriteria implements CriteriaInterface
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
            ->allowedFields(self::allowedVariationLinkFields())
            ->allowedFilters([
                'supplier',
                'key',
                'live' => AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                ])),
                'id' => AllowedFilter::exact('id'),
                'product_variation_id' => AllowedFilter::exact('product_variation_id'),
                'is_default' => AllowedFilter::exact('is_default'),
                'currency_id' => AllowedFilter::exact('currency_id'),
                'like' => AllowedFilter::exact('like'),
                'price' => AllowedFilter::exact('price'),
                'availability' => AllowedFilter::exact('availability'),
                'info_updated_at' => AllowedFilter::custom('date', new DateFilter(), 'info_updated_at'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'product_variation_id',
                'supplier',
                'key',
                'is_default',
                'check',
                'currency_id',
                'price',
                'availability',
                'info_updated_at',
            ])
            ->allowedIncludes([
                'productVariation',
                'currency',
            ]);
    }

    public static function allowedVariationLinkFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_variation_id',
            'supplier',
            'key',
            'is_default',
            'check',
            'currency_id',
            'price',
            'availability',
            'info_updated_at',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}

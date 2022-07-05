<?php

namespace Modules\Product\Builder;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request;
use Modules\Product\Http\Resources\FilteredProductResourceCollection;
use Modules\Product\Services\ProductFilter;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ProductFilterBuilder
{
    public function __construct(
        protected ProductFilter $productFilter
    ) {}

    public function getProductFilters(
        $rootValue, array $args,
        GraphQLContext $context,
        ResolveInfo $resolveInfo
    )
    {
        foreach ($args['filters'] as &$filter) {
            $filter['type'] = $filter['filter_type'];
            unset($filter['filter_type']);
        }

        $request = new Request($args);

        $products = $this->productFilter
            ->setFilters($request->input('filters') ?? [])
            ->setPage($request->input('page.number') ?? 1)
            ->setSize($request->input('page.size') ?? 15)
            ->setSort($request->input('orderBy') ?? 'popular')
            ->getItems();

        return [
            'data' => $products,
            'meta' => [
                'total' => $products->totalHits(),
                'aggregations' => $products->getAggregations(),
            ]
        ];
    }
}

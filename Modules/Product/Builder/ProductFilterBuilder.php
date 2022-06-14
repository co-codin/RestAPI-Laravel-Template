<?php

namespace Modules\Product\Builder;

use GraphQL\Type\Definition\ResolveInfo;
use Modules\Product\Http\Resources\FilteredProductResourceCollection;
use Modules\Product\Services\ProductFilter;

class ProductFilterBuilder
{
    public function __construct(
        protected ProductFilter $productFilter
    ) {}

    public function getProductFilters(
        $rootValue, array $args,
        GraphQLContext $context,
        ResolveInfo $resolveInfo
    ): FilteredProductResourceCollection
    {
        $products = $this->productFilter
            ->setFilters($args['filters'] ?? [])
            ->setPage($args['page.number'] ?? 1)
            ->setSize($args['page.size'] ?? 15)
            ->setSort($args['orderBy'] ?? 'popular')
            ->getItems();

        return new FilteredProductResourceCollection($products);
    }
}

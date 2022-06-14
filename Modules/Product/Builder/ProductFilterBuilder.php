<?php

namespace Modules\Product\Builder;

use GraphQL\Type\Definition\ResolveInfo;

class ProductFilterBuilder
{
    public function getProductFilters($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        dd($args);
    }
}

<?php

namespace Modules\Category\Services;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Models\Category;
use Modules\Product\Models\ProductCategory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class CategoryBuilder
{
    public function getRootCategories($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $productIds = $args['productIds'];

        return ProductCategory::query()
            ->with([
                'category' => fn($query) => $query->select('id', '_lft', '_rgt'),
                'category.ancestors' => fn($query) => $query->select('id', 'name', '_lft', '_rgt')->whereNull('parent_id'),
            ])
            ->whereIn('product_id', $productIds)
            ->where('is_main', true)
            ->get()
            ->map(fn($productCategory) => $productCategory->category->ancestors->first())
            ->groupBy('id')
            ->map(function($group) {
                $category = $group->first();
                return ['name' => $category->name, 'count' => $group->count(), 'id' => $category->id];
            })
            ->values();
    }
}

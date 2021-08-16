<?php

namespace Modules\Form\Casts;

use Modules\Category\Models\Category;
use Modules\Product\Models\Product;

/**
 * Class CategoryCast
 * @package Modules\Form\Casts
 */
class CategoryCast implements CastsInterface
{
    private ?Category $category = null;

    /**
     * @param string $slug
     * @return Category|null
     */
    public function get($slug): ?Category
    {
        if (!is_null($this->category)) {
            return $this->category;
        }

        $category = Category::query()
            ->where('slug', $slug)
            ->first();

        if (!is_null($category) && !is_null($category->parent_id)) {
            $category = $category
                ->getAncestors()
                ->where('parent_id', null)
                ->first();
        }

        return $this->category = $category;
    }

    /**
     * @param Product|null $product
     * @return Category|null
     */
    public function getCategoryByProduct(?Product $product = null): ?Category
    {
        if (!is_null($product) && $product->category()->exists()) {
            return $this->get($product->category->slug);
        }

        return null;
    }
}

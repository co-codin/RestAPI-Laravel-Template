<?php


namespace Modules\Form\Casts;


use Modules\Product\Models\Product;

/**
 * Class ProductCast
 * @package Modules\Form\Casts
 */
class ProductCast implements CastsInterface
{
    private ?Product $product = null;

    /**
     * @param int $productId
     * @return Product|null
     */
    public function get($productId): ?Product
    {
        if (!is_null($this->product)) {
            return $this->product;
        }

        return $this->product = Product::find($productId);
    }
}

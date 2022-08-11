<?php

namespace Modules\Product\Services;

use Illuminate\Support\Facades\DB;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Models\Product;

class ProductConfiguratorStorage
{
    /**
     * @throws \Throwable
     */
    public function update(Product $product, array $variations): void
    {
        activity()
            ->performedOn($product)
            ->event('updated')
            ->withProperties([
                'type' => 'variation',
                'old' => $product->productVariations,
                'new' => $variations,
            ])
        ;

        DB::beginTransaction();

        (new ProductVariationStorage($product, $variations))
            ->deleteNonExistentVariations()
            ->createNewVariations()
            ->updateExistingVariations();

        DB::commit();

        event(new ProductSaved($product));
    }
}

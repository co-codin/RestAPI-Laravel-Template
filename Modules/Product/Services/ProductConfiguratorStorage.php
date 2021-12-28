<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;

class ProductConfiguratorStorage
{
    /**
     * @throws \Throwable
     */
    public function update(Product $product, array $variations): void
    {
        DB::beginTransaction();

        (new ProductVariationStorage($product, Arr::except($variations, 'links')))
            ->deleteNonExistentVariations()
            ->createNewVariations()
            ->updateExistingVariations();

        DB::commit();

        event(new ProductSaved($product));
    }
}

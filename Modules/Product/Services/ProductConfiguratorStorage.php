<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;

class ProductConfiguratorStorage
{
    public function update(Product $product, array $variations)
    {
        DB::beginTransaction();

        (new ProductVariationStorage($product, $variations))
            ->deleteNonExistentVariations()
            ->createNewVariations()
            ->updateExistingVariations();

        DB::commit();
    }
}

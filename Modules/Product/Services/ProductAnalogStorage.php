<?php

namespace Modules\Product\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAnalog;

class ProductAnalogStorage
{
    /**
     * @throws \Exception
     * @return ProductAnalog[]|Collection
     */
    public function update(Product $product, array $validated): Collection
    {
        $productAnalogsData = collect($validated)
            ->map(function ($value) use ($product) {
                $value['product_id'] = $product->id;
                return $value;
            });

        return $product->analogs()->createMany($productAnalogsData);
    }
}

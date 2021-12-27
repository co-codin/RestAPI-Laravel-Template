<?php

namespace Modules\Product\Services;

use Modules\Product\Models\Product;

class ProductAnalogStorage
{
    /**
     * @throws \Exception
     */
    public function update(Product $product, array $validated): Product
    {
        $productAnalogsForSync = collect($validated)
            ->mapWithKeys(function ($value) {
                return [
                    $value['analog_id'] => ['position' => $value['position']]
                ];
            });

        $product->analogs()->sync($productAnalogsForSync);

        return $product->load('analogs');
    }
}

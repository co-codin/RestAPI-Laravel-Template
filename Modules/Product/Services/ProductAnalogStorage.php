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

        if (!ProductAnalog::insert($productAnalogsData->toArray())) {
            throw new \Exception('Can not create Product Analog');
        }

        $productAnalogs = $productAnalogsData->map(
            fn($productAnalogData) => new ProductAnalog($productAnalogData)
        );

        return new Collection($productAnalogs);
    }
}

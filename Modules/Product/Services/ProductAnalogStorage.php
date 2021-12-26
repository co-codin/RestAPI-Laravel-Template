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

        $productAnalogs = null;

        \DB::transaction(function () use ($product, $productAnalogsData, &$productAnalogs) {
            $product->analogs()->detach();
            $productAnalogs = $product->analogs()->createMany($productAnalogsData);
        });

        return $productAnalogs;
    }
}

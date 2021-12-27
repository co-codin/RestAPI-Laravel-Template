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
        $productAnalogsForSync = collect($validated['analogs'])
            ->mapWithKeys(function ($value) {
                return [
                    $value['analog_id'] => ['position' => $value['position']]
                ];
            });

        $product->analogs()->sync($productAnalogsForSync);

        if (!$product->update(['is_manually_analogs' => \Arr::get($validated, 'is_manually_analogs')])) {
            throw new \Exception('Не удалось изменить способ подбора аналогов');
        }

        return $product->load('analogs');
    }
}

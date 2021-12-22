<?php

namespace Modules\Product\Services;

use Modules\Product\Dto\ProductAnalogDto;
use Modules\Product\Models\ProductAnalog;

class ProductAnalogStorage
{
    /**
     * @throws \Exception
     */
    public function store(ProductAnalogDto $productAnalogDto): ProductAnalog
    {
        $productAnalog = new ProductAnalog($productAnalogDto->toArray());

        if (!$productAnalog->save()) {
            throw new \Exception('Can not create Product Analog');
        }

        return $productAnalog;
    }

    /**
     * @throws \Exception
     */
    public function update(ProductAnalog $productAnalog, ProductAnalogDto $productAnalogDto): ProductAnalog
    {
        if (!$productAnalog->update($productAnalogDto->toArray())) {
            throw new \Exception('Can not update Product Analog');
        }

        return $productAnalog;
    }

    /**
     * @throws \Exception
     */
    public function delete(ProductAnalog $productAnalog): void
    {
        if (!$productAnalog->delete()) {
            throw new \Exception('Can not delete Product Analog');
        }
    }
}

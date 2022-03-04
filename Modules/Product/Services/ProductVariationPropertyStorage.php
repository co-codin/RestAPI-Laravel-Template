<?php

namespace Modules\Product\Services;

use Modules\Product\Models\ProductVariationProperty;

class ProductVariationPropertyStorage
{
    public function update(array $data)
    {
        ProductVariationProperty::query()->create($data);
    }
}

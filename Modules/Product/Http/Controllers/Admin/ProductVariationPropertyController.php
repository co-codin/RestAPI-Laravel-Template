<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\Admin\ProductVariationPropertyUpdateRequest;
use Modules\Product\Services\ProductVariationPropertyStorage;

class ProductVariationPropertyController extends Controller
{
    public function __construct(
        protected ProductVariationPropertyStorage $productVariationPropertyStorage
    ) {}

    public function update(ProductVariationPropertyUpdateRequest $request)
    {
        $this->productVariationPropertyStorage->update($request->validated());

        return response()->noContent();
    }
}

<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\ProductConfiguratorUpdateRequest;
use Modules\Product\Services\ProductConfiguratorStorage;

class ProductConfiguratorController extends Controller
{
    public function __construct(
        protected ProductConfiguratorStorage $productConfiguratorStorage
    ) {}

    public function update(ProductConfiguratorUpdateRequest $request)
    {
        $this->productConfiguratorStorage->update($request->get('variants'));

        return response()->noContent();
    }
}

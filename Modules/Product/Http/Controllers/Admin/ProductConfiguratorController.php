<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\ProductConfiguratorUpdateRequest;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductConfiguratorStorage;

class ProductConfiguratorController extends Controller
{
    public function __construct(
        protected ProductConfiguratorStorage $productConfiguratorStorage,
        protected ProductRepository $productRepository
    ) {}

    public function update(int $product, ProductConfiguratorUpdateRequest $request)
    {
        $productModel = $this->productRepository->find($product);

        $this->productConfiguratorStorage->update($productModel, $request->input('variants'));

        return response()->noContent();
    }
}

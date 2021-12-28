<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\Admin\ProductConfiguratorUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductConfiguratorStorage;

class ProductConfiguratorController extends Controller
{
    public function __construct(
        protected ProductConfiguratorStorage $productConfiguratorStorage,
        protected ProductRepository $productRepository
    ) {}

    /**
     * @throws \Throwable
     */
    public function update(ProductConfiguratorUpdateRequest $request, int $productId): ProductResource
    {
        $product = $this->productRepository->find($productId);

        $this->productConfiguratorStorage->update($product, $request->input('variations'));

        return new ProductResource($product);
    }
}

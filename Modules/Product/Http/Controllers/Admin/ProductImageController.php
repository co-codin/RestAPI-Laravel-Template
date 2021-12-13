<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\Admin\ProductImageUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductImageStorage;

class ProductImageController extends Controller
{
    public function __construct(
        protected ProductImageStorage $productImageStorage,
        protected ProductRepository $productRepository
    ) {}

    public function update(int $product, ProductImageUpdateRequest $request)
    {
        $productModel = $this->productRepository->find($product);

        $this->productImageStorage->update($productModel, $request->input('images'));

        return new ProductResource($productModel);
    }
}

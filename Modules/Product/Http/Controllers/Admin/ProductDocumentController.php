<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\ProductDocumentUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductDocumentStorage;

class ProductDocumentController extends Controller
{
    public function __construct(
        protected ProductDocumentStorage $productDocumentStorage,
        protected ProductRepository $productRepository
    ) {}

    public function update(int $product, ProductDocumentUpdateRequest $request)
    {
        $productModel = $this->productRepository->find($product);

        $productModel = $this->productDocumentStorage->update($productModel, $request->validated());

        return new ProductResource($productModel);
    }
}

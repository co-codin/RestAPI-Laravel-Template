<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Http\Requests\Admin\ProductCreateRequest;
use Modules\Product\Http\Requests\Admin\ProductUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductStorage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductStorage $productStorage,
        protected ProductRepository $productRepository
    ) {}

    public function store(ProductCreateRequest $request)
    {
        $this->authorize('create', Product::class);

        $productDto = ProductDto::fromFormRequest($request);

        if (!$productDto->assigned_by_id) {
            $productDto->assigned_by_id = auth('sanctum')->id();
        }

        $product = $this->productStorage->store($productDto);

        return new ProductResource($product);
    }

    public function update(int $product, ProductUpdateRequest $request)
    {
        $product = $this->productRepository->find($product);

        $this->authorize('update', $product);

        $product = $this->productStorage->update($product, ProductDto::fromFormRequest($request));

        return new ProductResource($product);
    }

    public function destroy(int $product)
    {
        $product = $this->productRepository->find($product);

        $this->authorize('delete', $product);

        $this->productStorage->delete($product);

        return response()->noContent();
    }
}

<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Http\Requests\Admin\ProductCreateRequest;
use Modules\Product\Http\Requests\Admin\ProductUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Models\Product;
use Modules\Product\Services\ProductStorage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductStorage $productStorage,
    ) {
        $this->authorizeResource(Product::class, 'product');
    }

    public function store(ProductCreateRequest $request)
    {
        $productDto = ProductDto::fromFormRequest($request);

        if (!$productDto->assigned_by_id) {
            $productDto->assigned_by_id = auth('sanctum')->id();
        }

        $product = $this->productStorage->store($productDto);

        return new ProductResource($product);
    }

    public function update(Product $product, ProductUpdateRequest $request)
    {
        $product = $this->productStorage->update($product, ProductDto::fromFormRequest($request));

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->productStorage->delete($product);

        return response()->noContent();
    }
}

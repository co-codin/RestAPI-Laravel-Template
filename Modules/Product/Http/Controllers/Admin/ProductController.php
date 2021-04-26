<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Http\Requests\ProductCreateRequest;
use Modules\Product\Http\Requests\ProductUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Services\ProductStorage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductStorage $productStorage
    ) {}

    public function store(ProductCreateRequest $request)
    {
        $product = $this->productStorage->store(ProductDto::fromFormRequest($request));

        return new ProductResource($product);
    }

    public function update(int $product, ProductUpdateRequest $request)
    {

    }
}

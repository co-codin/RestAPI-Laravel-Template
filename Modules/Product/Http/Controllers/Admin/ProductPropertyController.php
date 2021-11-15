<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Http\Requests\Admin\ProductPropertyUpdateRequest;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductPropertyStorage;

class ProductPropertyController extends Controller
{
    public function __construct(
        protected ProductPropertyStorage $productPropertyStorage,
        protected ProductRepository $productRepository
    ) {}

    public function update(int $product, ProductPropertyUpdateRequest $request)
    {
        $productModel = $this->productRepository->find($product);

        ray($request->validated()['properties']);

        $this->productPropertyStorage->update($productModel, $request->validated()['properties']);

        event(new ProductSaved($productModel));

        return response()->noContent();
    }
}

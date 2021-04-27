<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\ProductPropertyUpdateRequest;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductPropertyStorage;

class ProductPropertyController extends Controller
{
    public function __construct(
        protected ProductPropertyStorage $productPropertyStorage,
        protected ProductRepository $productRepository
    ){}

    public function update(int $product, ProductPropertyUpdateRequest $request)
    {
        $productModel = $this->productRepository->find($product);

        $this->productPropertyStorage->update($productModel, $request->get('properties'));

        return response()->noContent();
    }
}

<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\Admin\ProductAnalogRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductAnalogStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductAnalogController extends Controller
{
    public function __construct(
        protected ProductAnalogStorage $productAnalogStorage,
        protected ProductRepository $productRepository
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(ProductAnalogRequest $request, int $productId): ProductResource
    {
        $product = $this->productRepository->find($productId);

        $productWithAnalogs = $this->productAnalogStorage->update(
            $product,
            $request->validated()
        );

        return new ProductResource($productWithAnalogs);
    }
}

<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Product\Dto\ProductAnalogDto;
use Modules\Product\Http\Requests\Admin\ProductAnalogRequest;
use Modules\Product\Http\Resources\ProductAnalogResource;
use Modules\Product\Repositories\ProductAnalogRepository;
use Modules\Product\Services\ProductAnalogStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductAnalogController extends Controller
{
    public function __construct(
        protected ProductAnalogStorage $productStorage,
        protected ProductAnalogRepository $productRepository
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(ProductAnalogRequest $request): ProductAnalogResource
    {
        $product = $this->productStorage->store(
            ProductAnalogDto::fromFormRequest($request)
        );

        return new ProductAnalogResource($product);
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(ProductAnalogRequest $request, int $productId): ProductAnalogResource
    {
        $product = $this->productRepository->find($productId);

        $product = $this->productStorage->update(
            $product,
            ProductAnalogDto::fromFormRequest($request)
        );

        return new ProductAnalogResource($product);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $productId): Response
    {
        $product = $this->productRepository->find($productId);

        $this->productStorage->delete($product);

        return response()->noContent();
    }
}

<?php

namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Resources\ProductAnalogResource;
use Modules\Product\Repositories\ProductRepository;

class ProductAnalogController extends Controller
{
    public function __construct(
        private ProductRepository $repository
    ) {}

    public function show(int $productId): AnonymousResourceCollection
    {
        $product = $this->repository->find($productId);

        return ProductAnalogResource::collection($product->analogs);
    }
}

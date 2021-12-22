<?php

namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Resources\ProductAnalogResource;
use Modules\Product\Repositories\ProductAnalogRepository;

class ProductAnalogController extends Controller
{
    public function __construct(
        private ProductAnalogRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductAnalogResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productAnalogId): ProductAnalogResource
    {
        return new ProductAnalogResource(
            $this->repository->find($productAnalogId)
        );
    }
}

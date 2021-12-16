<?php

namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Resources\ProductAnswerResource;
use Modules\Product\Repositories\ProductAnswerRepository;

class ProductAnswerController extends Controller
{
    public function __construct(
        private ProductAnswerRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductAnswerResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productAnswerId): ProductAnswerResource
    {
        return new ProductAnswerResource(
            $this->repository->find($productAnswerId)
        );
    }
}

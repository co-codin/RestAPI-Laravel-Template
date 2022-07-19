<?php

namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Resources\ProductAnswerResource;
use Modules\Product\Models\ProductAnswer;
use Modules\Product\Repositories\ProductAnswerRepository;

class ProductAnswerController extends Controller
{
    public function __construct(
        private ProductAnswerRepository $repository
    ) {
        $this->authorizeResource(ProductAnswer::class, 'product_answer');
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductAnswerResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(ProductAnswer $product_answer): ProductAnswerResource
    {
        return new ProductAnswerResource($product_answer);
    }
}

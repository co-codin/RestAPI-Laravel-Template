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
        protected ProductAnswerRepository $productAnswerRepository
    ) {}

    public function index()
    {
        return ProductAnswerResource::collection(
            $this->productAnswerRepository->jsonPaginate()
        );
    }

    public function show(int $product_answer): ProductAnswerResource
    {
        $product_answer = $this->productAnswerRepository->find($product_answer);

        return new ProductAnswerResource($product_answer);
    }
}

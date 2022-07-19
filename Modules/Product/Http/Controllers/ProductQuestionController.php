<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Resources\ProductQuestionResource;
use Modules\Product\Models\ProductQuestion;
use Modules\Product\Repositories\ProductQuestionRepository;

class ProductQuestionController extends Controller
{
    public function __construct(
        private ProductQuestionRepository $repository
    ) {
        $this->authorizeResource(ProductQuestion::class, 'product_question');
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductQuestionResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(ProductQuestion $product_question): ProductQuestionResource
    {
        return new ProductQuestionResource($product_question);
    }
}

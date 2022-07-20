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
        protected ProductQuestionRepository $productQuestionRepository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', ProductQuestion::class);

        return ProductQuestionResource::collection(
            $this->productQuestionRepository->jsonPaginate()
        );
    }

    public function show(int $product_question): ProductQuestionResource
    {
        $product_question = $this->productQuestionRepository($product_question);

        $this->authorize('view', $product_question);

        return new ProductQuestionResource($product_question);
    }
}

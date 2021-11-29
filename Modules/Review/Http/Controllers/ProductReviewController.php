<?php

namespace Modules\Review\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Review\Http\Requests\ProductReviewCreateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Models\ProductReview;
use Modules\Review\Repositories\ProductReviewRepository;

class ProductReviewController extends Controller
{
    public function __construct(
        private ProductReviewRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $productReviews = $this->repository->jsonPaginate();

        return ProductReviewResource::collection($productReviews);
    }

    public function show(ProductReview $productReview): ProductReviewResource
    {
        return new ProductReviewResource($productReview);
    }

    public function store(ProductReviewCreateRequest $request): Renderable
    {
        //
    }
}

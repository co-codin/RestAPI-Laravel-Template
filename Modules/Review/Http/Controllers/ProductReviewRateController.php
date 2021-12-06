<?php

namespace Modules\Review\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Modules\Review\Enums\ProductReviewRateStatus;
use Modules\Review\Http\Requests\ProductReviewRateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewRateService;

class ProductReviewRateController extends Controller
{
    public function __construct(
        private ProductReviewRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductReviewResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    /**
     * @throws \Exception
     */
    public function rate(
        ProductReviewRateRequest $request,
        ProductReviewRateService $service,
        int $productReviewId
    ): Response
    {
        $productReview = $this->repository->find($productReviewId);

        $service->changeRate(
            $productReview,
            ProductReviewRateStatus::fromValue($request->validated()['status'])
        );

        return \response()->noContent();
    }
}

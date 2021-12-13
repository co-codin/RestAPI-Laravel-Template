<?php

namespace Modules\Review\Http\Controllers;

use App\Enums\RateStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Requests\RateRequest;
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewRateService;

class ProductReviewRateController extends Controller
{
    public function __construct(
        private ProductReviewRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function rate(
        RateRequest $request,
        ProductReviewRateService $service,
        int $productReviewId
    ): Response
    {
        $productReview = $this->repository->find($productReviewId);

        $newCookie = $service->changeRate(
            $productReview,
            RateStatus::fromValue($request->validated()['status'])
        );

        return (new Response())->withCookie(
            \Cookie::forever('product_review_rate', serialize($newCookie))
        );
    }
}

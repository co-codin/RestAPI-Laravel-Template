<?php

namespace Modules\Review\Http\Controllers;

use App\Enums\RateStatus;
use App\Http\Controllers\Controller;
use App\Services\RateService;
use Illuminate\Http\Response;
use App\Http\Requests\RateRequest;
use Modules\Review\Repositories\ProductReviewRepository;

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
        RateService $service,
        int $productReviewId
    ): Response
    {
        $productReview = $this->repository->find($productReviewId);

        $data = $service->changeRate(
            $productReview,
            RateStatus::fromValue($request->validated()['status'])
        );

        $newCookie = unserialize(\Cookie::get('product_review_rate'));
        $newCookie[$data['id']] = $data['status'];

        return (new Response())->withCookie(
            \Cookie::forever('product_review_rate', serialize($newCookie))
        );
    }
}

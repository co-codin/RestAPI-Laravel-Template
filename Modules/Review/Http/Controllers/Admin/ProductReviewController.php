<?php

namespace Modules\Review\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Http\Requests\ProductReviewApproveRequest;
use Modules\Review\Http\Requests\Admin\ProductReviewCreateRequest as ProductReviewCreateAdminRequest;
use Modules\Review\Http\Requests\ProductReviewUpdateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Models\ProductReview;
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewStorage;

class ProductReviewController extends Controller
{
    public function __construct(
        protected ProductReviewStorage $productReviewStorage,
        protected ProductReviewRepository $productReviewRepository
    ) {}

    public function store(
        ProductReviewCreateAdminRequest $request,
        ProductReviewStorage $storage,
    ): ProductReviewResource
    {
        $this->authorize('viewAny', ProductReview::class);

        $productReview = $storage->store(
            ProductReviewDto::fromFormRequest($request)
        );

        return new ProductReviewResource($productReview);
    }

    public function update(
        ProductReviewUpdateRequest $request,
        int $product_review
    ): ProductReviewResource
    {
        $product_review = $this->productReviewRepository->find($product_review);

        $this->authorize('update', $product_review);

        $productReview = $this->productReviewStorage->update(
            $product_review,
            ProductReviewDto::fromFormRequest($request)
        );

        return new ProductReviewResource($productReview);
    }

    public function destroy(int $product_review): Response
    {
        $product_review = $this->productReviewRepository->find($product_review);

        $this->authorize('delete', $product_review);

        $this->productReviewStorage->delete($product_review);

        return response()->noContent();
    }

    public function approve(
        ProductReviewApproveRequest $request,
        int $product_review
    ): Response
    {
        $product_review = $this->productReviewRepository->find($product_review);

        $this->authorize('approve', $product_review);

        $this->productReviewStorage->changeStatus(
            $product_review,
            ProductReviewStatus::fromValue(ProductReviewStatus::APPROVED)
        );

        if ($product_review?->client?->email) {
            $this->productReviewStorage->notifyApproveOrReject(
                $product_review,
                $request->validated()['comment']
            );
        }

        return \response()->noContent();
    }

    public function reject(
        ProductReviewApproveRequest $request,
        int $product_review
    ): Response
    {
        $product_review = $this->productReviewRepository->find($product_review);

        $this->authorize('reject', $product_review);

        $this->productReviewStorage->changeStatus(
            $product_review,
            ProductReviewStatus::fromValue(ProductReviewStatus::REJECTED)
        );

        $this->productReviewStorage->notifyApproveOrReject(
            $product_review,
            $request->validated()['comment']
        );

        return response()->noContent();
    }
}

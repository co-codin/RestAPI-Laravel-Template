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
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductReviewController extends Controller
{
    public function __construct(
        private ProductReviewRepository $repository,
        private ProductReviewStorage $storage
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(
        ProductReviewCreateAdminRequest $request,
        ProductReviewStorage $storage,
    ): ProductReviewResource
    {
        $productReview = $storage->store(
            ProductReviewDto::fromFormRequest($request)
        );

        return new ProductReviewResource($productReview);
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        ProductReviewUpdateRequest $request,
        int $productReviewId
    ): ProductReviewResource
    {
        $productReview = $this->storage->update(
            $this->repository->find($productReviewId),
            ProductReviewDto::fromFormRequest($request)
        );

        return new ProductReviewResource($productReview);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $productReviewId): Response
    {
        $this->storage->delete(
            $this->repository->find($productReviewId)
        );

        return \response()->noContent();
    }


    /**
     * @throws \Exception
     */
    public function approve(
        ProductReviewApproveRequest $request,
        int $productReviewId
    ): Response
    {
        $productReview = $this->repository->find($productReviewId);

        $this->storage->changeStatus(
            $productReview,
            ProductReviewStatus::fromValue(ProductReviewStatus::APPROVED)
        );

        if ($productReview?->client?->email) {
            $this->storage->notifyApproveOrReject(
                $productReview,
                $request->validated()['comment']
            );
        }

        return \response()->noContent();
    }

    /**
     * @throws \Exception
     */
    public function reject(
        ProductReviewApproveRequest $request,
        int $productReviewId
    ): Response
    {
        $productReview = $this->repository->find($productReviewId);

        $this->storage->changeStatus(
            $this->repository->find($productReviewId),
            ProductReviewStatus::fromValue(ProductReviewStatus::REJECTED)
        );

        $this->storage->notifyApproveOrReject(
            $productReview,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }
}

<?php

namespace Modules\Review\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Http\Requests\ProductReviewApproveRequest;
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
        $this->storage->approve(
            $this->repository->find($productReviewId),
            $request->validated()['comment']
        );

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
        $this->storage->approve(
            $this->repository->find($productReviewId),
            $request->validated()['comment'],
            false
        );

        return \response()->noContent();
    }
}

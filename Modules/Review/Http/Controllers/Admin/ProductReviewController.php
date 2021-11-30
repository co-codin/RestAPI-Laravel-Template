<?php

namespace Modules\Review\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Http\Requests\ProductReviewUpdateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Models\ProductReview;
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductReviewController extends Controller
{
    public function __construct(
        private ProductReviewRepository $repository
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        ProductReviewUpdateRequest $request,
        ProductReviewStorage $storage,
        int $productReviewId
    ): ProductReviewResource
    {
        $productReview = $storage->update(
            $this->repository->find($productReviewId),
            ProductReviewDto::fromFormRequest($request)
        );

        return new ProductReviewResource($productReview);
    }

    public function destroy(ProductReview $productReview): Response
    {
        $productReview->delete();

        return \response()->noContent();
    }
}

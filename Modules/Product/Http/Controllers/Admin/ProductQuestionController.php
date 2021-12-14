<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Product\Dto\ProductQuestionDto;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Http\Requests\Admin\ProductQuestionApproveOrRejectRequest;
use Modules\Product\Http\Requests\Admin\ProductQuestionUpdateRequest;
use Modules\Product\Http\Resources\ProductQuestionResource;
use Modules\Product\Repositories\ProductQuestionRepository;
use Modules\Product\Services\Qna\ProductQuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductQuestionController extends Controller
{
    public function __construct(
        private ProductQuestionRepository $repository,
        private ProductQuestionStorage $storage
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        ProductQuestionUpdateRequest $request,
        int $productQuestionId
    ): ProductQuestionResource
    {
        $productQuestion = $this->storage->update(
            $this->repository->find($productQuestionId),
            ProductQuestionDto::fromFormRequest($request)
        );

        return new ProductQuestionResource($productQuestion);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $productQuestionId): Response
    {
        $this->storage->delete(
            $this->repository->find($productQuestionId)
        );

        return \response()->noContent();
    }


    /**
     * @throws \Exception
     */
    public function approve(
        ProductQuestionApproveOrRejectRequest $request,
        int $productQuestionId
    ): Response
    {
        $productQuestion = $this->repository->find($productQuestionId);

        $this->storage->changeStatus(
            $productQuestion,
            ProductQuestionStatus::fromValue(ProductQuestionStatus::APPROVED)
        );

        $this->storage->notifyApproveOrReject(
            $productQuestion,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }

    /**
     * @throws \Exception
     */
    public function reject(
        ProductQuestionApproveOrRejectRequest $request,
        int $productQuestionId
    ): Response
    {
        $productQuestion = $this->repository->find($productQuestionId);

        $this->storage->changeStatus(
            $this->repository->find($productQuestionId),
            ProductQuestionStatus::fromValue(ProductQuestionStatus::REJECTED)
        );

        $this->storage->notifyApproveOrReject(
            $productQuestion,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }
}

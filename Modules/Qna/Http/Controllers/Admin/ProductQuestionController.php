<?php

namespace Modules\Qna\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Qna\Dto\ProductQuestionDto;
use Modules\Qna\Enums\ProductQuestionStatus;
use Modules\Qna\Http\Requests\ProductQuestionApproveOrRejectRequest;
use Modules\Qna\Http\Requests\ProductQuestionUpdateRequest;
use Modules\Qna\Http\Resources\ProductQuestionResource;
use Modules\Qna\Repositories\ProductQuestionRepository;
use Modules\Qna\Services\ProductQuestionStorage;
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

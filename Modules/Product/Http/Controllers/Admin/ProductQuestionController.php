<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Product\Dto\ProductQuestionDto;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Http\Requests\Admin\ProductQuestionApproveOrRejectRequest;
use Modules\Product\Http\Requests\Admin\ProductQuestionUpdateRequest;
use Modules\Product\Http\Requests\Admin\ProductQuestionCreateRequest;
use Modules\Product\Http\Resources\ProductQuestionResource;
use Modules\Product\Models\ProductQuestion;
use Modules\Product\Repositories\ProductQuestionRepository;
use Modules\Product\Services\Qna\ProductQuestionStorage;

class ProductQuestionController extends Controller
{
    public function __construct(
        protected ProductQuestionStorage $productQuestionStorage,
        protected ProductQuestionRepository $productQuestionRepository,
    ) {}

    public function store(
        ProductQuestionCreateRequest $request,
    ): ProductQuestionResource
    {
        $this->authorize('create', ProductQuestion::class);

        $productQuestion = $this->productQuestionStorage->store(ProductQuestionDto::fromFormRequest($request));

        return new ProductQuestionResource($productQuestion);
    }

    public function update(
        ProductQuestionUpdateRequest $request,
        int $product_question
    ): ProductQuestionResource
    {
        $product_question = $this->productQuestionRepository->find($product_question);

        $this->authorize('update', $product_question);

        $product_question = $this->productQuestionStorage->update(
            $product_question,
            ProductQuestionDto::fromFormRequest($request)
        );

        return new ProductQuestionResource($product_question);
    }

    public function destroy(int $product_question): Response
    {
        $product_question = $this->productQuestionRepository->find($product_question);

        $this->authorize('delete', $product_question);

        $this->productQuestionStorage->delete($product_question);

        return \response()->noContent();
    }

    public function approve(
        ProductQuestionApproveOrRejectRequest $request,
        int $product_question
    ): Response
    {
        $product_question = $this->productQuestionRepository->find($product_question);

        $this->authorize('update', $product_question);

        $this->productQuestionStorage->changeStatus(
            $product_question,
            ProductQuestionStatus::fromValue(ProductQuestionStatus::APPROVED)
        );

        $this->productQuestionStorage->notifyApproveOrReject(
            $product_question,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }

    public function reject(
        ProductQuestionApproveOrRejectRequest $request,
        int $product_question
    ): Response
    {
        $product_question = $this->productQuestionRepository->find($product_question);

        $this->authorize('update', $product_question);

        $this->productQuestionStorage->changeStatus(
            $product_question,
            ProductQuestionStatus::fromValue(ProductQuestionStatus::REJECTED)
        );

        $this->productQuestionStorage->notifyApproveOrReject(
            $product_question,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }
}

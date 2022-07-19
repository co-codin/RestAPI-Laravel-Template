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
use Modules\Product\Services\Qna\ProductQuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductQuestionController extends Controller
{
    public function __construct(
        protected ProductQuestionStorage $productQuestionStorage
    ) {
        $this->authorizeResource(ProductQuestion::class, 'product_question');
    }

    public function store(
        ProductQuestionCreateRequest $request,
    ): ProductQuestionResource
    {
        $productQuestion = $this->productQuestionStorage->store(ProductQuestionDto::fromFormRequest($request));

        return new ProductQuestionResource($productQuestion);
    }

    public function update(
        ProductQuestionUpdateRequest $request,
        ProductQuestion $product_question
    ): ProductQuestionResource
    {
        $product_question = $this->productQuestionStorage->update(
            $product_question,
            ProductQuestionDto::fromFormRequest($request)
        );

        return new ProductQuestionResource($product_question);
    }

    public function destroy(ProductQuestion $product_question): Response
    {
        $this->productQuestionStorage->delete($product_question);

        return \response()->noContent();
    }

    public function approve(
        ProductQuestionApproveOrRejectRequest $request,
        ProductQuestion $product_question
    ): Response
    {
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
        ProductQuestion $product_question
    ): Response
    {
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

<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Product\Dto\ProductAnswerDto;
use Modules\Product\Http\Requests\Admin\ProductAnswerRequest;
use Modules\Product\Http\Resources\ProductAnswerResource;
use Modules\Product\Models\ProductAnswer;
use Modules\Product\Repositories\ProductAnswerRepository;
use Modules\Product\Services\Qna\ProductAnswerStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductAnswerController extends Controller
{
    public function __construct(
        protected ProductAnswerStorage $productAnswerStorage,
        protected ProductAnswerRepository $productAnswerRepository
    ) {}

    public function store(ProductAnswerRequest $request)
    {
        $this->authorize('create', ProductAnswer::class);

        $answer = $this->productAnswerStorage->store(
            ProductAnswerDto::fromFormRequest($request)
        );

        return new ProductAnswerResource($answer);
    }

    public function update(
        ProductAnswerRequest $request,
        int $product_answer
    ): ProductAnswerResource
    {
        $product_answer = $this->productAnswerRepository->find($product_answer);

        $this->authorize('update', $product_answer);

        $answer = $this->productAnswerStorage->update(
            $product_answer,
            ProductAnswerDto::fromFormRequest($request)
        );

        return new ProductAnswerResource($answer);
    }

    public function destroy(int $product_answer): Response
    {
        $product_answer = $this->productAnswerRepository->find($product_answer);

        $this->authorize('delete', $product_answer);

        $this->productAnswerStorage->delete($product_answer);

        return response()->noContent();
    }

    public function persons()
    {
        return ProductAnswer::query()
            ->select(['first_name', 'last_name', 'person'])
            ->groupBy(['first_name', 'last_name', 'person'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }
}

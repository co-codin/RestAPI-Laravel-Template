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
        private ProductAnswerStorage $storage
    ) {
        $this->authorizeResource(ProductAnswer::class, 'product_answer');
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(ProductAnswerRequest $request): ProductAnswerResource
    {
        $answer = $this->storage->store(
            ProductAnswerDto::fromFormRequest($request)
        );

        return new ProductAnswerResource($answer);
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        ProductAnswerRequest $request,
        ProductAnswer $product_answer
    ): ProductAnswerResource
    {
        $answer = $this->storage->update(
            $product_answer,
            ProductAnswerDto::fromFormRequest($request)
        );

        return new ProductAnswerResource($answer);
    }

    /**
     * @throws \Exception
     */
    public function destroy(ProductAnswer $product_answer): Response
    {
        $this->storage->delete($product_answer);

        return \response()->noContent();
    }

    /**
     * Get all added unique question repliers
     * @return array
     */
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

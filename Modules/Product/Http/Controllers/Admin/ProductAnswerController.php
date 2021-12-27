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
        private ProductAnswerRepository $repository,
        private ProductAnswerStorage $storage
    ) {}

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
        int $productAnswerId
    ): ProductAnswerResource
    {
        $answer = $this->storage->update(
            $this->repository->find($productAnswerId),
            ProductAnswerDto::fromFormRequest($request)
        );

        return new ProductAnswerResource($answer);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $productAnswerId): Response
    {
        $this->storage->delete(
            $this->repository->find($productAnswerId)
        );

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

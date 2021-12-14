<?php

namespace Modules\Qna\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Qna\Dto\ProductAnswerDto;
use Modules\Qna\Http\Requests\ProductAnswerRequest;
use Modules\Qna\Http\Resources\ProductAnswerResource;
use Modules\Qna\Repositories\ProductAnswerRepository;
use Modules\Qna\Services\ProductAnswerStorage;
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
}

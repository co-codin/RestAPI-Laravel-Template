<?php

namespace Modules\Review\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Form\Helpers\FormRequestHelper;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Http\Requests\ProductReviewCreateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductReviewController extends Controller
{
    public function __construct(
        private ProductReviewRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductReviewResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productReviewId): ProductReviewResource
    {
        return new ProductReviewResource(
            $this->repository->find($productReviewId)
        );
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(
        ProductReviewCreateRequest $request,
        ProductReviewStorage $storage,
    ): ProductReviewResource
    {
        $clientData = app(FormRequestHelper::class)->getClientData();

        $validated = array_merge(
            ['client_id' => $clientData['auth_id']],
            $request->validated()
        );

        $productReview = $storage->store(
            ProductReviewDto::create($validated)->visible(array_keys($validated))
        );

        return new ProductReviewResource($productReview);
    }
}

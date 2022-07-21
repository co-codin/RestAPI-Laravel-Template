<?php

namespace Modules\Review\Http\Controllers;

use App\Helpers\ClientAuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Http\Requests\ProductReviewCreateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Models\ProductReview;
use Modules\Review\Repositories\ProductReviewRepository;
use Modules\Review\Services\ProductReviewStorage;

class ProductReviewController extends Controller
{
    public function __construct(
        protected ProductReviewRepository $productReviewRepository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductReviewResource::collection(
            $this->productReviewRepository->jsonPaginate()
        );
    }

    public function show(int $product_review): ProductReviewResource
    {
        $product_review = $this->productReviewRepository->find($product_review);

        return new ProductReviewResource($product_review);
    }

    public function store(
        ProductReviewCreateRequest $request,
        ProductReviewStorage $storage,
    ): ProductReviewResource
    {
        ClientAuthHelper::authorize($request);

        $clientData = app(ClientAuthHelper::class)->getClientData();

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

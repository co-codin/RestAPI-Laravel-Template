<?php

namespace Modules\Review\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Http\Requests\ProductReviewCreateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Repositories\ProductReviewRepository;

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

    public function store(
        ProductReviewCreateRequest $request,
        ProductReviewService $service,
    ): Renderable
    {
        $dto = ProductReviewDto::create(
            array_merge(
                ['client_id' => \Auth::user()->id,],
                $request->validated()
            )
        );

        $service->save($dto);
    }
}

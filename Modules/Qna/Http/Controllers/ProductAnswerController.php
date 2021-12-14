<?php

namespace Modules\Qna\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Qna\Http\Resources\ProductAnswerResource;
use Modules\Qna\Repositories\ProductAnswerRepository;

class ProductAnswerController extends Controller
{
    public function __construct(
        private ProductAnswerRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductAnswerResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productAnswerId): ProductAnswerResource
    {
        return new ProductAnswerResource(
            $this->repository->find($productAnswerId)
        );
    }
}

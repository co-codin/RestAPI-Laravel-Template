<?php

namespace Modules\Qna\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Qna\Http\Resources\AnswerResource;
use Modules\Qna\Repositories\AnswerRepository;

class AnswerController extends Controller
{
    public function __construct(
        private AnswerRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return AnswerResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productReviewId): AnswerResource
    {
        return new AnswerResource(
            $this->repository->find($productReviewId)
        );
    }
}

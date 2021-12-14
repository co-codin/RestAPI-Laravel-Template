<?php

namespace Modules\Qna\Http\Controllers;

use App\Helpers\ClientAuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Qna\Http\Resources\QuestionResource;
use Modules\Qna\Repositories\QuestionRepository;
use Modules\Qna\Dto\QuestionDto;
use Modules\Qna\Http\Requests\QuestionCreateRequest;
use Modules\Qna\Services\QuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return QuestionResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productReviewId): QuestionResource
    {
        return new QuestionResource(
            $this->repository->find($productReviewId)
        );
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(
        QuestionCreateRequest $request,
        QuestionStorage $storage,
    ): QuestionResource
    {
        ClientAuthHelper::authorize($request);

        $clientData = app(ClientAuthHelper::class)->getClientData();

        $validated = array_merge(
            ['client_id' => $clientData['auth_id']],
            $request->validated()
        );

        $productReview = $storage->store(
            QuestionDto::create($validated)->visible(array_keys($validated))
        );

        return new QuestionResource($productReview);
    }
}

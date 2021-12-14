<?php

namespace Modules\Qna\Http\Controllers;

use App\Helpers\ClientAuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Qna\Http\Resources\ProductQuestionResource;
use Modules\Qna\Repositories\ProductQuestionRepository;
use Modules\Qna\Dto\ProductQuestionDto;
use Modules\Qna\Http\Requests\ProductQuestionCreateRequest;
use Modules\Qna\Services\ProductQuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductQuestionController extends Controller
{
    public function __construct(
        private ProductQuestionRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductQuestionResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $productQuestionId): ProductQuestionResource
    {
        return new ProductQuestionResource(
            $this->repository->find($productQuestionId)
        );
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(
        ProductQuestionCreateRequest $request,
        ProductQuestionStorage $storage,
    ): ProductQuestionResource
    {
        ClientAuthHelper::authorize($request);

        $clientData = app(ClientAuthHelper::class)->getClientData();

        $validated = array_merge(
            ['client_id' => $clientData['auth_id']],
            $request->validated()
        );

        $productQuestion = $storage->store(
            ProductQuestionDto::create($validated)->visible(array_keys($validated))
        );

        return new ProductQuestionResource($productQuestion);
    }
}

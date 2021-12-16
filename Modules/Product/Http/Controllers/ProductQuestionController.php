<?php

namespace Modules\Product\Http\Controllers;

use App\Helpers\ClientAuthHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Dto\ProductQuestionDto;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Http\Requests\ProductQuestionCreateRequest;
use Modules\Product\Http\Resources\ProductQuestionResource;
use Modules\Product\Repositories\ProductQuestionRepository;
use Modules\Product\Services\Qna\ProductQuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use function app;

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
            [
                'client_id' => $clientData['auth_id'],
                'status' => ProductQuestionStatus::IN_MODERATION,
                'date' => Carbon::now()->toDateTimeString(),
            ],
            $request->validated()
        );

        $productQuestion = $storage->store(
            ProductQuestionDto::create($validated)->visible(array_keys($validated))
        );

        return new ProductQuestionResource($productQuestion);
    }
}

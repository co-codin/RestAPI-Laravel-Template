<?php

namespace Modules\Product\Http\Controllers;

use App\Helpers\ClientAuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Dto\ProductQuestionDto;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Http\Requests\ProductQuestionCreateRequest;
use Modules\Product\Http\Resources\ProductQuestionResource;
use Modules\Product\Models\ProductQuestion;
use Modules\Product\Repositories\ProductQuestionRepository;
use Modules\Product\Services\Qna\ProductQuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductQuestionController extends Controller
{
    public function __construct(
        protected ProductQuestionRepository $productQuestionRepository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductQuestionResource::collection(
            $this->productQuestionRepository->jsonPaginate()
        );
    }

    public function show(int $product_question): ProductQuestionResource
    {
        $product_question = $this->productQuestionRepository->find($product_question);

        return new ProductQuestionResource($product_question);
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
            ],
            $request->validated()
        );

        $productQuestion = $storage->store(
            ProductQuestionDto::create($validated)->visible(array_keys($validated))
        );

        return new ProductQuestionResource($productQuestion);
    }
}

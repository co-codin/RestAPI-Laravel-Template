<?php

namespace Modules\Qna\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use Modules\Form\Helpers\FormRequestHelper;
use Modules\Qna\Repositories\QuestionRepository;
use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Http\Requests\ProductReviewCreateRequest;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Services\ProductReviewStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionRepository $repository
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
        $this->clientAuthorize($request);

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

    protected function clientAuthorize(Request $request)
    {
        $response = Http::baseUrl(config('services.crm.domain'))
            ->withToken($request->bearerToken())
            ->get('/clients/show');

        if ($response->failed()) {
            abort(401);
        }

        $request->offsetSet('client', $response->json());
    }
}

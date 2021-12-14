<?php

namespace Modules\Qna\Http\Controllers;

use App\Enums\RateStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use Illuminate\Http\Response;
use Modules\Qna\Repositories\ProductAnswerRepository;
use Modules\Qna\Services\ProductAnswerRateService;

class ProductAnswerRateController extends Controller
{
    public function __construct(
        private ProductAnswerRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function rate(
        RateRequest              $request,
        ProductAnswerRateService $service,
        int                      $productAnswerId
    ): Response
    {
        $productAnswer = $this->repository->find($productAnswerId);

        $newCookie = $service->changeRate(
            $productAnswer,
            RateStatus::fromValue($request->validated()['status'])
        );

        return (new Response())->withCookie(
            \Cookie::forever('product_answer_rate', serialize($newCookie))
        );
    }
}

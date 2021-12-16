<?php

namespace Modules\Product\Http\Controllers;

use App\Enums\RateStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Services\RateService;
use Illuminate\Http\Response;
use Modules\Product\Repositories\ProductAnswerRepository;

class ProductAnswerRateController extends Controller
{
    public function __construct(
        private ProductAnswerRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function rate(
        RateRequest $request,
        RateService $service,
        int $productAnswerId
    ): Response
    {
        $productAnswer = $this->repository->find($productAnswerId);

        $data = $service->changeRate(
            $productAnswer,
            RateStatus::fromValue($request->validated()['status'])
        );

        $newCookie = unserialize(\Cookie::get('product_answer_rate'));
        $newCookie[$data['id']] = $data['status'];

        return (new Response())->withCookie(
            \Cookie::forever('product_answer_rate', serialize($newCookie))
        );
    }
}

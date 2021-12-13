<?php

namespace Modules\Qna\Http\Controllers;

use App\Enums\RateStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use Illuminate\Http\Response;
use Modules\Qna\Repositories\AnswerRepository;
use Modules\Qna\Services\AnswerRateService;

class AnswerRateController extends Controller
{
    public function __construct(
        private AnswerRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function rate(
        RateRequest $request,
        AnswerRateService $service,
        int $answerId
    ): Response
    {
        $answer = $this->repository->find($answerId);

        $newCookie = $service->changeRate(
            $answer,
            RateStatus::fromValue($request->validated()['status'])
        );

        return (new Response())->withCookie(
            \Cookie::forever('qna_rate', serialize($newCookie))
        );
    }
}

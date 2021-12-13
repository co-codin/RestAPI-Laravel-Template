<?php

namespace Modules\Qna\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Qna\Dto\AnswerDto;
use Modules\Qna\Http\Requests\AnswerApproveOrRejectRequest;
use Modules\Qna\Http\Requests\AnswerRequest;
use Modules\Qna\Http\Resources\AnswerResource;
use Modules\Qna\Repositories\AnswerRepository;
use Modules\Qna\Services\AnswerStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AnswerController extends Controller
{
    public function __construct(
        private AnswerRepository $repository,
        private AnswerStorage $storage
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        AnswerRequest $request,
        int $answerId
    ): AnswerResource
    {
        $answer = $this->storage->update(
            $this->repository->find($answerId),
            AnswerDto::fromFormRequest($request)
        );

        return new AnswerResource($answer);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $answerId): Response
    {
        $this->storage->delete(
            $this->repository->find($answerId)
        );

        return \response()->noContent();
    }
}

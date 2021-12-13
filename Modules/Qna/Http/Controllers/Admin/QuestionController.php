<?php

namespace Modules\Qna\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Qna\Dto\QuestionDto;
use Modules\Qna\Enums\QuestionStatus;
use Modules\Qna\Http\Requests\QuestionApproveOrRejectRequest;
use Modules\Qna\Http\Requests\QuestionUpdateRequest;
use Modules\Qna\Http\Resources\QuestionResource;
use Modules\Qna\Repositories\QuestionRepository;
use Modules\Qna\Services\QuestionStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionRepository $repository,
        private QuestionStorage $storage
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        QuestionUpdateRequest $request,
        int $questionId
    ): QuestionResource
    {
        $question = $this->storage->update(
            $this->repository->find($questionId),
            QuestionDto::fromFormRequest($request)
        );

        return new QuestionResource($question);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $questionId): Response
    {
        $this->storage->delete(
            $this->repository->find($questionId)
        );

        return \response()->noContent();
    }


    /**
     * @throws \Exception
     */
    public function approve(
        QuestionApproveOrRejectRequest $request,
        int                            $questionId
    ): Response
    {
        $question = $this->repository->find($questionId);

        $this->storage->changeStatus(
            $question,
            QuestionStatus::fromValue(QuestionStatus::APPROVED)
        );

        $this->storage->notifyApproveOrReject(
            $question,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }

    /**
     * @throws \Exception
     */
    public function reject(
        QuestionApproveOrRejectRequest $request,
        int                            $questionId
    ): Response
    {
        $question = $this->repository->find($questionId);

        $this->storage->changeStatus(
            $this->repository->find($questionId),
            QuestionStatus::fromValue(QuestionStatus::REJECTED)
        );

        $this->storage->notifyApproveOrReject(
            $question,
            $request->validated()['comment']
        );

        return \response()->noContent();
    }
}

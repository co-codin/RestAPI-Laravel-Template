<?php

namespace Modules\Faq\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Faq\Dto\QuestionDto;
use Modules\Faq\Http\Requests\QuestionCreateRequest;
use Modules\Faq\Http\Requests\QuestionSortRequest;
use Modules\Faq\Http\Requests\QuestionUpdateRequest;
use Modules\Faq\Http\Resources\QuestionResource;
use Modules\Faq\Repositories\Criteria\ActiveStatusCriteria;
use Modules\Faq\Repositories\QuestionRepository;
use Modules\Faq\Services\QuestionStorage;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionRepository $questionRepository,
        protected QuestionStorage $questionStorage
    ) {
        $this->questionRepository->popCriteria(ActiveStatusCriteria::class);
    }

    public function index()
    {
        $questions = $this->questionRepository->jsonPaginate();

        return QuestionResource::collection($questions);
    }

    public function show(int $question)
    {
        $questionModel = $this->questionRepository->find($question);

        return new QuestionResource($questionModel);
    }

    public function store(QuestionCreateRequest $request)
    {
        $questionModel = $this->questionStorage->store(QuestionDto::fromFormRequest($request));

        return new QuestionResource($questionModel);
    }

    public function update(int $question, QuestionUpdateRequest $request)
    {
        $questionModel = $this->questionRepository->find($question);

        $questionModel = $this->questionStorage->update($questionModel, QuestionDto::fromFormRequest($request));

        return new QuestionResource($questionModel);
    }

    public function destroy(int $question)
    {
        $questionModel = $this->questionRepository->find($question);

        $this->questionStorage->delete($questionModel);

        return response()->noContent();
    }

    public function sort(QuestionSortRequest $request)
    {
        $this->questionStorage->sort($request->get('questions'));

        return response()->noContent();
    }
}

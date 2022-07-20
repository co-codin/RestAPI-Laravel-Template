<?php

namespace Modules\Faq\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Faq\Dto\QuestionDto;
use Modules\Faq\Http\Requests\QuestionCreateRequest;
use Modules\Faq\Http\Requests\QuestionSortRequest;
use Modules\Faq\Http\Requests\QuestionUpdateRequest;
use Modules\Faq\Http\Resources\QuestionResource;
use Modules\Faq\Models\Question;
use Modules\Faq\Repositories\QuestionRepository;
use Modules\Faq\Services\QuestionStorage;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionStorage $questionStorage,
        protected QuestionRepository $questionRepository
    ) {}

    public function store(QuestionCreateRequest $request)
    {
        $this->authorize('create', Question::class);

        $questionModel = $this->questionStorage->store(QuestionDto::fromFormRequest($request));

        return new QuestionResource($questionModel);
    }

    public function update(int $question, QuestionUpdateRequest $request)
    {
        $question = $this->questionRepository->find($question);

        $this->authorize('update', $question);

        $question = $this->questionStorage->update($question, (new QuestionDto($request->validated()))->only(...$request->keys()));

        return new QuestionResource($question);
    }

    public function destroy(int $question)
    {
        $question = $this->questionRepository->find($question);

        $this->authorize('delete', $question);

        $this->questionStorage->delete($question);

        return response()->noContent();
    }

    public function sort(QuestionSortRequest $request)
    {
        $this->authorize('sort', Question::class);

        $this->questionStorage->sort($request->get('questions'));

        return response()->noContent();
    }
}

<?php

namespace Modules\Faq\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Faq\Dto\QuestionDto;
use Modules\Faq\Http\Requests\QuestionCreateRequest;
use Modules\Faq\Http\Requests\QuestionSortRequest;
use Modules\Faq\Http\Requests\QuestionUpdateRequest;
use Modules\Faq\Http\Resources\QuestionResource;
use Modules\Faq\Models\Question;
use Modules\Faq\Services\QuestionStorage;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionStorage $questionStorage
    ) {
        $this->authorizeResource(Question::class, 'question');
    }

    public function store(QuestionCreateRequest $request)
    {
        $questionModel = $this->questionStorage->store(QuestionDto::fromFormRequest($request));

        return new QuestionResource($questionModel);
    }

    public function update(Question $question, QuestionUpdateRequest $request)
    {
        $question = $this->questionStorage->update($question, (new QuestionDto($request->validated()))->only(...$request->keys()));

        return new QuestionResource($question);
    }

    public function destroy(Question $question)
    {
        $this->questionStorage->delete($question);

        return response()->noContent();
    }

    public function sort(QuestionSortRequest $request)
    {
        $this->questionStorage->sort($request->get('questions'));

        return response()->noContent();
    }
}

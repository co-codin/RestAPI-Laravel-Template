<?php

namespace Modules\Faq\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Faq\Dto\QuestionCategoryDto;
use Modules\Faq\Dto\QuestionDto;
use Modules\Faq\Http\Requests\QuestionCategoryCreateRequest;
use Modules\Faq\Http\Requests\QuestionCategoryUpdateRequest;
use Modules\Faq\Http\Requests\QuestionCreateRequest;
use Modules\Faq\Http\Requests\QuestionUpdateRequest;
use Modules\Faq\Http\Resources\QuestionCategoryResource;
use Modules\Faq\Http\Resources\QuestionResource;
use Modules\Faq\Repositories\Criteria\ActiveStatusCriteria;
use Modules\Faq\Repositories\QuestionCategoryRepository;
use Modules\Faq\Repositories\QuestionRepository;
use Modules\Faq\Services\QuestionCategoryStorage;
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

        return new QuestionCategoryResource($questionModel);
    }

    public function update(int $question, QuestionUpdateRequest $request)
    {
        $questionCategoryModel = $this->questionCategoryRepository->find($question_category);

        $questionCategoryModel = $this->questionCategoryStorage->update($questionCategoryModel, QuestionCategoryDto::fromFormRequest($request));

        return new QuestionCategoryResource($questionCategoryModel);
    }

    public function destroy(int $question_category)
    {
        $questionCategoryModel = $this->questionCategoryRepository->find($question_category);

        $this->questionCategoryStorage->delete($questionCategoryModel);

        return response()->noContent();
    }
}

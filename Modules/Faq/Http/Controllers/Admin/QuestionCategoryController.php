<?php

namespace Modules\Faq\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Faq\Dto\QuestionCategoryDto;
use Modules\Faq\Http\Requests\QuestionCategoryCreateRequest;
use Modules\Faq\Http\Requests\QuestionCategorySortRequest;
use Modules\Faq\Http\Requests\QuestionCategoryUpdateRequest;
use Modules\Faq\Http\Resources\QuestionCategoryResource;
use Modules\Faq\Repositories\QuestionCategoryRepository;
use Modules\Faq\Services\QuestionCategoryStorage;

class QuestionCategoryController extends Controller
{
    public function __construct(
        protected QuestionCategoryRepository $questionCategoryRepository,
        protected QuestionCategoryStorage $questionCategoryStorage
    ) {}

    public function store(QuestionCategoryCreateRequest $request)
    {
        $questionCategoryModel = $this->questionCategoryStorage->store(QuestionCategoryDto::fromFormRequest($request));

        return new QuestionCategoryResource($questionCategoryModel);
    }

    public function update(int $question_category, QuestionCategoryUpdateRequest $request)
    {
        $questionCategoryModel = $this->questionCategoryRepository->find($question_category);

        $questionCategoryModel = $this->questionCategoryStorage->update($questionCategoryModel, (new QuestionCategoryDto($request->validated()))->only(...$request->keys()));

        return new QuestionCategoryResource($questionCategoryModel);
    }

    public function destroy(int $question_category)
    {
        $questionCategoryModel = $this->questionCategoryRepository->find($question_category);

        $this->questionCategoryStorage->delete($questionCategoryModel);

        return response()->noContent();
    }

    public function sort(QuestionCategorySortRequest $request)
    {
        $this->questionCategoryStorage->sort($request->get('categories'));

        return response()->noContent();
    }
}

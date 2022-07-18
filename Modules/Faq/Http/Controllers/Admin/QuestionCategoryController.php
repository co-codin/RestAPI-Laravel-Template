<?php

namespace Modules\Faq\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Faq\Dto\QuestionCategoryDto;
use Modules\Faq\Http\Requests\QuestionCategoryCreateRequest;
use Modules\Faq\Http\Requests\QuestionCategorySortRequest;
use Modules\Faq\Http\Requests\QuestionCategoryUpdateRequest;
use Modules\Faq\Http\Resources\QuestionCategoryResource;
use Modules\Faq\Models\QuestionCategory;
use Modules\Faq\Repositories\QuestionCategoryRepository;
use Modules\Faq\Services\QuestionCategoryStorage;

class QuestionCategoryController extends Controller
{
    public function __construct(
        protected QuestionCategoryStorage $questionCategoryStorage
    ) {
        $this->authorizeResource(QuestionCategory::class, 'question_category');
    }

    public function store(QuestionCategoryCreateRequest $request)
    {
        $questionCategoryModel = $this->questionCategoryStorage->store(QuestionCategoryDto::fromFormRequest($request));

        return new QuestionCategoryResource($questionCategoryModel);
    }

    public function update(QuestionCategory $question_category, QuestionCategoryUpdateRequest $request)
    {
        $question_category = $this->questionCategoryStorage->update($question_category, QuestionCategoryDto::fromFormRequest($request));

        return new QuestionCategoryResource($question_category);
    }

    public function destroy(QuestionCategory $question_category)
    {
        $this->questionCategoryStorage->delete($question_category);

        return response()->noContent();
    }

    public function sort(QuestionCategorySortRequest $request)
    {
        $this->questionCategoryStorage->sort($request->get('categories'));

        return response()->noContent();
    }
}

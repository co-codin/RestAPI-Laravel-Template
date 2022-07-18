<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Faq\Http\Resources\QuestionCategoryResource;
use Modules\Faq\Models\QuestionCategory;
use Modules\Faq\Repositories\QuestionCategoryRepository;

class QuestionCategoryController extends Controller
{
    public function __construct(
        protected QuestionCategoryRepository $questionCategoryRepository
    ) {
        $this->authorizeResource(QuestionCategory::class, 'question_category');
    }

    public function all()
    {
        $this->authorize('viewAny', QuestionCategory::class);

        $questionCategories = $this->questionCategoryRepository->all();

        return QuestionCategoryResource::collection($questionCategories);
    }

    public function index()
    {
        $questionCategories = $this->questionCategoryRepository->jsonPaginate();

        return QuestionCategoryResource::collection($questionCategories);
    }

    public function show(QuestionCategory $question_category)
    {
        return new QuestionCategoryResource($question_category);
    }
}

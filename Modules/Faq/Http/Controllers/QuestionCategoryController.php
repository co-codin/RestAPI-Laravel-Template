<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Faq\Http\Resources\QuestionCategoryResource;
use Modules\Faq\Repositories\QuestionCategoryRepository;

class QuestionCategoryController extends Controller
{
    public function __construct(
        protected QuestionCategoryRepository $questionCategoryRepository
    ) {}

    public function index()
    {
        $questionCategories = $this->questionCategoryRepository->jsonPaginate();

        return QuestionCategoryResource::collection($questionCategories);
    }

    public function show(string $slug)
    {
        $questionCategory = $this->questionCategoryRepository->findBySlug($slug);

        return new QuestionCategoryResource($questionCategory);
    }
}

<?php

namespace Modules\Faq\Http\Controllers;

use App\Enums\Status;
use Illuminate\Routing\Controller;
use Modules\Faq\Http\Resources\QuestionCategoryPageResource;
use Modules\Faq\Repositories\QuestionCategoryRepository;

class QuestionCategoryPageController extends Controller
{
    public function __construct(
        protected QuestionCategoryRepository $questionCategoryRepository
    ) {
        $this->questionCategoryRepository->resetCriteria();
    }

    public function index()
    {
        $questionCategories = $this->questionCategoryRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug')
                    ->withActiveQuestions()
                    ;
            })
            ->with(['questions' => function ($query) {
                $query->addSelect('question_category_id', 'question', 'slug', 'answer');
            }])
            ->orderBy('position', 'asc')
            ->findWhere([
                'status' => Status::ACTIVE
            ])
            ->all()
        ;

        return QuestionCategoryPageResource::collection($questionCategories);
    }
}

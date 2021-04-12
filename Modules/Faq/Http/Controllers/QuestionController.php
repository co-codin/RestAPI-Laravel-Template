<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Faq\Http\Resources\QuestionResource;
use Modules\Faq\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionRepository $questionRepository
    ) {}

    public function index()
    {
        $questions = $this->questionRepository->jsonPaginate();

        return QuestionResource::collection($questions);
    }

    public function show(int $question)
    {
        $question = $this->questionRepository->find($question);

        return new QuestionResource($question);
    }
}

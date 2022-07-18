<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Faq\Http\Resources\QuestionResource;
use Modules\Faq\Models\Question;
use Modules\Faq\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionRepository $questionRepository
    ) {
        $this->authorizeResource(Question::class, 'question');
    }

    public function index()
    {
        $questions = $this->questionRepository->jsonPaginate();

        return QuestionResource::collection($questions);
    }

    public function show(Question $question)
    {
        return new QuestionResource($question);
    }
}

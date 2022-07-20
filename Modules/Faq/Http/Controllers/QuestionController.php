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
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Question::class);

        $questions = $this->questionRepository->jsonPaginate();

        return QuestionResource::collection($questions);
    }

    public function show(int $question)
    {
        $question = $this->questionRepository->find($question);

        $this->authorize('view', $question);

        return new QuestionResource($question);
    }
}

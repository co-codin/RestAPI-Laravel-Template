<?php


namespace Modules\Qna\Repositories;


use App\Repositories\BaseRepository;
use Modules\Qna\Models\Question;
use Modules\Qna\Repositories\Criteria\QuestionRequestCriteria;

/**
 * @property Question $model
 */
class QuestionRepository extends BaseRepository
{
    public function model(): string
    {
        return Question::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(QuestionRequestCriteria::class);
    }
}

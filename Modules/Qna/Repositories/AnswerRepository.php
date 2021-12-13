<?php


namespace Modules\Qna\Repositories;


use App\Repositories\BaseRepository;
use Modules\Qna\Models\Answer;
use Modules\Qna\Repositories\Criteria\AnswerRequestCriteria;

/**
 * @property Answer $model
 */
class AnswerRepository extends BaseRepository
{
    public function model(): string
    {
        return Answer::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(AnswerRequestCriteria::class);
    }
}

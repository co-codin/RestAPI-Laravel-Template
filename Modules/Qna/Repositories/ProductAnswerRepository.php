<?php


namespace Modules\Qna\Repositories;


use App\Repositories\BaseRepository;
use Modules\Qna\Models\ProductAnswer;
use Modules\Qna\Repositories\Criteria\AnswerRequestCriteria;

/**
 * @property ProductAnswer $model
 */
class ProductAnswerRepository extends BaseRepository
{
    public function model(): string
    {
        return ProductAnswer::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(AnswerRequestCriteria::class);
    }
}

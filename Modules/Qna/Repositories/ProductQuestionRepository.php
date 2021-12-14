<?php


namespace Modules\Qna\Repositories;


use App\Repositories\BaseRepository;
use Modules\Qna\Models\ProductQuestion;
use Modules\Qna\Repositories\Criteria\ProductQuestionRequestCriteria;

/**
 * @property ProductQuestion $model
 */
class ProductQuestionRepository extends BaseRepository
{
    public function model(): string
    {
        return ProductQuestion::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(ProductQuestionRequestCriteria::class);
    }
}

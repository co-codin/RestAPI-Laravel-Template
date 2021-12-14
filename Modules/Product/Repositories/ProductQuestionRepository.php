<?php


namespace Modules\Product\Repositories;


use App\Repositories\BaseRepository;
use Modules\Product\Models\ProductQuestion;
use Modules\Product\Repositories\Criteria\ProductQuestionRequestCriteria;

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

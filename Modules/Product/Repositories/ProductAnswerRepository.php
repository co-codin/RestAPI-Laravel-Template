<?php


namespace Modules\Product\Repositories;


use App\Repositories\BaseRepository;
use Modules\Product\Models\ProductAnswer;
use Modules\Product\Repositories\Criteria\AnswerRequestCriteria;

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

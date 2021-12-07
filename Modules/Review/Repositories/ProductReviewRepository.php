<?php


namespace Modules\Review\Repositories;


use App\Repositories\BaseRepository;
use Modules\Review\Models\ProductReview;
use Modules\Review\Repositories\Criteria\ProductReviewRequestCriteria;

/**
 * @property ProductReview $model
 */
class ProductReviewRepository extends BaseRepository
{
    public function model(): string
    {
        return ProductReview::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(ProductReviewRequestCriteria::class);
    }
}

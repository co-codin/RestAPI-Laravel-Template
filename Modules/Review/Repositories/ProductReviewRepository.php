<?php


namespace Modules\Review\Repositories;


use Modules\Review\Models\ProductReview;
use Modules\Review\Repositories\Criteria\ProductReviewRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

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

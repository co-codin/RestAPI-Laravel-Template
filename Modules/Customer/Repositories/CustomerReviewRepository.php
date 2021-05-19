<?php


namespace Modules\Customer\Repositories;


use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Customer\Models\CustomerReview;
use Modules\Customer\Repositories\Criteria\CustomerReviewRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

/**
 * Class CustomerReviewRepository
 * @package Modules\Customer\Repositories
 * @property CustomerReview $model
 */
class CustomerReviewRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CustomerReview::class;
    }

    public function boot()
    {
        $this->pushCriteria(CustomerReviewRequestCriteria::class);
    }
}

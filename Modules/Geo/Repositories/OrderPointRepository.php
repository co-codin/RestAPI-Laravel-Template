<?php

namespace Modules\Geo\Repositories;

use App\Repositories\BaseRepository;
use Modules\Geo\Models\OrderPoint;
use Modules\Geo\Repositories\Criteria\OrderPointRequestCriteria;

class OrderPointRepository extends BaseRepository
{
    public function model()
    {
        return OrderPoint::class;
    }

    public function boot()
    {
        $this->pushCriteria(OrderPointRequestCriteria::class);
    }
}

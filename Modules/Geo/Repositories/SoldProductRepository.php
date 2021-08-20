<?php

namespace Modules\Geo\Repositories;

use App\Repositories\BaseRepository;
use Modules\Geo\Models\SoldProduct;
use Modules\Geo\Repositories\Criteria\SoldProductRequestCriteria;

class SoldProductRepository extends BaseRepository
{
    public function model()
    {
        return SoldProduct::class;
    }

    public function boot()
    {
        $this->pushCriteria(SoldProductRequestCriteria::class);
    }
}

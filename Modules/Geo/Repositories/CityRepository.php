<?php

namespace Modules\Geo\Repositories;

use App\Repositories\BaseRepository;
use Modules\Geo\Models\City;
use Modules\Geo\Repositories\Criteria\CityRequestCriteria;

class CityRepository extends BaseRepository
{
    public function model()
    {
        return City::class;
    }

    public function boot()
    {
        $this->pushCriteria(CityRequestCriteria::class);
    }
}

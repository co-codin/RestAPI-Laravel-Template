<?php

namespace Modules\Cabinet\Repositories;

use App\Repositories\BaseRepository;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Repositories\Criteria\CabinetRequestCriteria;

class CabinetRepository extends BaseRepository
{
    public function model()
    {
        return Cabinet::class;
    }

    public function boot()
    {
        $this->pushCriteria(CabinetRequestCriteria::class);
    }
}

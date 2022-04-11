<?php

namespace Modules\Case\Repositories;

use App\Repositories\BaseRepository;
use Modules\Case\Models\CaseModel;
use Modules\Case\Repositories\Criteria\CaseRequestCriteria;

class CaseRepository extends BaseRepository
{
    public function model()
    {
        return CaseModel::class;
    }

    public function boot()
    {
        $this->pushCriteria(CaseRequestCriteria::class);
    }
}

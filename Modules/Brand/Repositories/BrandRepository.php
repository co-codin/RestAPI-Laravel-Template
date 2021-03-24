<?php


namespace Modules\Brand\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Criteria\IsActiveCriteria;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;

class BrandRepository extends BaseRepository
{
    public function boot()
    {
        $this->pushCriteria(IsActiveCriteria::class);
        $this->pushCriteria(BrandRequestCriteria::class);
    }

    public function model()
    {
        return Brand::class;
    }
}

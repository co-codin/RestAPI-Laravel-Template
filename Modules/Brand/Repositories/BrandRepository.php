<?php


namespace Modules\Brand\Repositories;

use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class BrandRepository extends BaseRepository
{
    public function boot()
    {
        $this->pushCriteria(BrandRequestCriteria::class);
    }

    public function model()
    {
        return Brand::class;
    }
}

<?php


namespace Modules\Brand\Repositories;

use Modules\Brand\Models\Brand;
use Prettus\Repository\Eloquent\BaseRepository;

class BrandRepository extends BaseRepository
{
    public function getActiveBrands()
    {
        return $this->model->where('status', 1)->get();
    }

    public function model()
    {
        return Brand::class;
    }
}

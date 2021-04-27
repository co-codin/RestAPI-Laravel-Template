<?php


namespace Modules\Product\Repositories;


use App\Repositories\BaseRepository;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }

    public function boot()
    {
        $this->pushCriteria(ProductRequestCriteria::class);
    }
}

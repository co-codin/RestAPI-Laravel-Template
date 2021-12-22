<?php


namespace Modules\Product\Repositories;


use App\Repositories\BaseRepository;
use Modules\Product\Models\ProductAnalog;
use Modules\Product\Repositories\Criteria\ProductAnalogRequestCriteria;

/**
 * @property ProductAnalog $model
 */
class ProductAnalogRepository extends BaseRepository
{
    public function model(): string
    {
        return ProductAnalog::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(ProductAnalogRequestCriteria::class);
    }
}

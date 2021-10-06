<?php


namespace Modules\Brand\Repositories;

use App\Repositories\BaseRepository;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;
use Modules\Search\Contracts\IndexableRepository;
use Spatie\QueryBuilder\QueryBuilder;

class BrandRepository extends BaseRepository implements IndexableRepository
{
    public function model()
    {
        return Brand::class;
    }

    public function boot()
    {
        $this->pushCriteria(BrandRequestCriteria::class);
    }

    public function getItemsToIndex()
    {
        return $this->scopeQuery(function (QueryBuilder $builder) {
            return $builder
                ->select([
                    'id',
                    'name',
                    'slug',
                    'status',
                    'country',
                ]);
        });
    }
}

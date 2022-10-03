<?php

namespace Modules\Product\Repositories\Criteria;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Modules\Product\Enums\ProductGroup;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductHotCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereExists(function (QueryBuilder $builder) {
            $builder
                ->select(DB::raw(1))
                ->from('product_variations as pv')
                ->whereColumn('product_id', 'products.id')
                ->whereNotNull('pv.previous_price')
                ->whereNotNull('pv.price')
                ->where('group_id', '!=', ProductGroup::IMPOSSIBLE)
                ->where('pv.is_price_visible', true);
        });
    }

}

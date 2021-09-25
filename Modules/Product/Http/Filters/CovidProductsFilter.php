<?php


namespace Modules\Product\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

class CovidProductsFilter implements Filter
{
    const COVID_PROPERTY_ID = 259;

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereExists(function($query) use ($value) {
            $query->select(DB::raw(1))
                ->from('product_property as pp')
                ->whereColumn('pp.product_id', 'products.id')
                ->where('pp.property_id', static::COVID_PROPERTY_ID)
                ->whereJsonContains('pp.value', true);
        });
    }
}

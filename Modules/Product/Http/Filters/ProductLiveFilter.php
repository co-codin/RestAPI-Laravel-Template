<?php


namespace Modules\Product\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ProductLiveFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        collect(str_getcsv($value, ' ', '"'))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = preg_replace('/[^A-ZА-Яа-яa-z0-9]/', '', $term);
                $query->whereIn('id', function ($query) use ($term) {
                    $query->select('id')
                        ->from(function ($query) use ($term) {
                            $query->select('products.id')
                                ->from('products')
                                ->where('products.name', 'like', '%'. $term . '%')
                                ->orWhere('products.id', '=', $term)
                                ->union(
                                    $query->newQuery()
                                        ->select('products.id')
                                        ->from('products')
                                        ->join('brands', 'products.brand_id', '=', 'brands.id')
                                        ->where('brands.name', 'like', '%'. $term . '%')
                                );
                        }, 'matches');
            });
        });
    }

    protected function f() {

    }
}
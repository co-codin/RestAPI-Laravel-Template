<?php


namespace Modules\Product\Http\Filters;


use DB;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use Validator;

class ProductPropertyFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $this->validate($value);

        foreach ($value as $propertyValue) {
            $query->whereExists(function($query) use($propertyValue) {
                $query->select(DB::raw(1))
                    ->from('product_property as pp')
                    ->whereColumn('pp.product_id', 'products.id')
                    ->where('pp.property_id', $propertyValue['id'])
                    ->whereJsonContains('pp.value', $propertyValue['value']);
            });
        }
    }

    protected function validate($value)
    {
        Validator::validate(['properties' => $value], [
            'properties' => [
                'required',
                'array',
            ],
            'properties.*' => [
                'required',
                'array',
            ],
            'properties.*.id' => [
                'required',
                'integer',
                'distinct'
            ],
            'properties.*.value' => [
                'required',
                'nullable',
            ],
        ]);
    }
}

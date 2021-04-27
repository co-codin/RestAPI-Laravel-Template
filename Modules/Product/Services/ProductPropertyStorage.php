<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Modules\Product\Models\Product;

class ProductPropertyStorage
{
    public function update(Product $product, array $properties)
    {
        $properties = $this->groupBy('id', $properties);
        $product->properties()->detach();
        $product->properties()->attach($properties);
    }

    protected function groupBy($key, array $data)
    {
        $result = array();

        foreach($data as $val) {
            $result[$val[$key]][] = Arr::flatten($val);
        }

        return $result;
    }
}

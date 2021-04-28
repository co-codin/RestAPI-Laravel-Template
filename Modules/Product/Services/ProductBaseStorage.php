<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;

class ProductBaseStorage
{
    protected function groupBy(array $categories)
    {
        $data = [];

        foreach ($categories as $category) {
            $data[$category['id']] = Arr::except($category, 'id');
        }

        return $data;
    }
}

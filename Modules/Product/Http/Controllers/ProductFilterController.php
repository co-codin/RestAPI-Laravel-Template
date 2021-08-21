<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Product\Http\Requests\ProductFilterRequest;
use Modules\Product\Http\Resources\FilteredProductResourceCollection;
use Modules\Product\Services\ProductFilter;

class ProductFilterController extends Controller
{
    public function index(
        ProductFilterRequest $request,
        ProductFilter $productFilter
    )
    {
        $products = $productFilter->getItems();

        return new FilteredProductResourceCollection($products);
    }
}

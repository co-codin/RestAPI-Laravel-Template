<?php


namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;

class ProductFilterController extends Controller
{
    public function index($product_slug, $category_slug, $filters)
    {
        dd(
            $product_slug,
            $category_slug,
            $filters
        );
    }
}

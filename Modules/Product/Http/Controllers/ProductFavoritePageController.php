<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\Http\Resources\ProductFavoritePageResource;
use Modules\Product\Repositories\Criteria\ProductFavoritePageCriteria;
use Modules\Product\Repositories\ProductRepository;

class ProductFavoritePageController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {
        $this->productRepository
            ->resetCriteria()
            ->pushCriteria(ProductFavoritePageCriteria::class)
        ;
    }

    public function index()
    {
        $productIds = request()->get('ids');
        $categoryId = request()->get('category_id');
        $priceSort = request()->get('price_sort');
        $page = request()->get('page');
        $perPage = request()->get('per_page');

        $products = $this->productRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->withPrice()
                    ->withMainVariation()
                    ;
            })
            ;

        return ProductFavoritePageResource::collection($productIds);
    }
}

<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Models\Category;
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
        $priceSort = request()->get('price_sort') ?? 'ASC';
        $page = request()->get('page');
        $perPage = request()->get('per_page');

        $products = $this->productRepository
            ->scopeQuery(function ($query) use ($categoryId, $productIds) {
                $query = $query
                    ->whereIn('id', $productIds)
                    ->withPrice()
                    ->withMainVariation()
                    ;

                if ($categoryId) {
                    $rootCategory = Category::findOrFail($categoryId);

                    $categoryIds = $rootCategory->descendants()
                        ->pluck('id')
                        ->add($rootCategory->id);

                    $query = $query
                        ->whereHas(
                            'productCategories',
                            fn($builder) => $builder->whereIn('category_id', $categoryIds)
                        );
                }
                return $query;
            })
            ->orderBy('price', $priceSort)
            ->paginate($perPage, $page)
            ;

        return ProductFavoritePageResource::collection($products);
    }
}

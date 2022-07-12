<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Models\Category;
use Modules\Product\Repositories\Criteria\ProductComparePageCriteria;
use Modules\Product\Repositories\ProductRepository;

class ProductComparePageController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    )
    {
        $this->productRepository
            ->resetCriteria()
            ->pushCriteria(ProductComparePageCriteria::class);
    }

    public function index()
    {
        $productIds = request()->get('ids');
        $categoryId = request()->get('category_id');

        return $this->productRepository
            ->scopeQuery(function ($query) use ($categoryId) {
                $query = $query
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
            ->findWhereIn('id', $productIds)
            ->all()
            ;
    }
}

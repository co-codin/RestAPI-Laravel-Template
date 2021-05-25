<?php


namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\Filters\ProductFilter;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Filter\Collections\FilterCollection;
use Modules\Filter\Models\Filter;

class ProductFilterController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ProductFilter $productFilter
    ) {}

    public function index($category_slug, $filters)
    {
        $filters = Filter::query()->whereIn('slug', explode("/", $filters))->get()->unique();

        $category = $this->categoryRepository->findWhere([
            'slug' => $category_slug,
        ])->first();

        $products = $this->productFilter->setCategory($category)
            ->setFilters(new FilterCollection($filters))
            ->getProducts();

        dd(
            $products
        );
    }
}

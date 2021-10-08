<?php

namespace Modules\Search\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Search\Http\Requests\SearchRequest;
use Modules\Search\Services\BrandSearchService;
use Modules\Search\Services\CategorySearchService;
use Modules\Search\Services\ProductSearchService;

class SearchController extends Controller
{
    public function __construct(
        private CategorySearchService $categorySearchService,
        private BrandSearchService    $brandSearchService,
        private ProductSearchService  $productSearchService
    ) {}

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function live(SearchRequest $request)
    {
        $term = $request->get('term');

        $categories = $this->categorySearchService->getLiveSearchCategories($term, 3);
        $brands = $this->brandSearchService->getLiveSearchBrands($term, 3);
        $products = $this->productSearchService->getLiveSearchProducts($term);

        $result = array_merge($categories, $brands, $products);

        return response()->json(
            array_slice($result, 0, 10)
        );
    }

    /**
     * @throws \Throwable
     */
    public function index(SearchRequest $request)
    {
        $term = $request->get('term');
        $products = $this->productSearchService->getProductsForSearchPage($term, 12);

        return [
            'term' => $term,
            'products' => $products,
        ];
    }
}

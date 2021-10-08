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

//    /**
//     * @return Factory|JsonResponse|View
//     * @throws Throwable
//     */
//    public function index(SearchRequest $request, SearchPagePresenter $presenter)
//    {
//        $term = $request->get('term');
//        $products = $this->productSearchService->getProductsForSearchPage($term, 12);
//
//        $products->transform(function ($product) {
//            return new ProductPresenter($product);
//        });
//
//        if ($request->wantsJson()) {
//            $products_html = view('product::_full', compact('products'))->render();
//            $products_meta = \Arr::except($products->toArray(), 'data');
//            return response()->json([
//                'products' => [
//                    'html' => $products_html,
//                    'meta' => $products_meta,
//                ],
//            ]);
//        }
//
//        return view('search::index', [
//            'presenter' => $presenter,
//            'products' => $products,
//            'term' => $term,
//        ]);
//    }
}

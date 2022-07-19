<?php


namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    ){
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        $products = $this->productRepository->jsonPaginate();

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}

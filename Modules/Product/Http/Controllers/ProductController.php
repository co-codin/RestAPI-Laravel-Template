<?php


namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Product\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

    public function index()
    {

    }

    public function show(int $product)
    {

    }
}

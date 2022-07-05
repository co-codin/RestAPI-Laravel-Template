<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Repositories\ProductRepository;

class ProductPageController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

     public function show(int $product)
     {
        
     }
}

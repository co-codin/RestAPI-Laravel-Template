<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
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
        
    }
}

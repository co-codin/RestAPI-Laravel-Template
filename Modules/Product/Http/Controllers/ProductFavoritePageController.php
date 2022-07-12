<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\Repositories\ProductRepository;

class ProductFavoritePageController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    )
    {
        $this->productRepository
            ->resetCriteria();
    }

    public function index()
    {

    }
}

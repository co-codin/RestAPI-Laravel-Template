<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\ProductCreateRequest;
use Modules\Product\Services\ProductStorage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductStorage $productStorage
    ) {}

    public function store(ProductCreateRequest $request)
    {

    }

    public function update()
    {

    }
}

<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Http\Resources\BrandResource;

class BrandController extends Controller
{
    public function __construct(
        protected BrandRepository $brandRepository
    ) {
        $this->authorizeResource(Brand::class, 'brand');
    }

    public function index()
    {
        $brands = $this->brandRepository->jsonPaginate();

        return BrandResource::collection($brands);
    }

    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }
}

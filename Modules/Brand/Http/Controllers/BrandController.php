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
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Brand::class);

        $brands = $this->brandRepository->jsonPaginate();

        return BrandResource::collection($brands);
    }

    public function show(int $brand)
    {
        $brand = $this->brandRepository->find($brand);

        $this->authorize('viewAny', Brand::class);

        return new BrandResource($brand);
    }
}

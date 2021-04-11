<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Http\Resources\BrandResource;

class BrandController extends Controller
{
    public function __construct(
        protected BrandRepository $brandRepository
    ) {}

    public function index()
    {
        $brands = $this->brandRepository->jsonPaginate();

        return BrandResource::collection($brands);
    }

    public function show(int $brand)
    {
        $brandModel = $this->brandRepository->find($brand);

        return new BrandResource($brandModel);
    }
}

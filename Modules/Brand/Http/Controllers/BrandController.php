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

    public function show(string $slug)
    {
        $brand = $this->brandRepository->findBySlug($slug) ?? abort(404);

        return new BrandResource($brand);
    }
}

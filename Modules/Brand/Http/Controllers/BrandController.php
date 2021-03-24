<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\IsActiveCriteria;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Transformers\BrandResource;

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

    public function show(string $brand)
    {
        $brand = $this->brandRepository->findWhere([
            'slug' => $brand
        ]);

        return new BrandResource($brand);
    }
}

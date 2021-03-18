<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Transformers\BrandResource;

class BrandController extends Controller
{
    protected BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->all();

        return BrandResource::collection($brands);
    }

    public function show(int $brand)
    {
        $brand = $this->brandRepository->find($brand);

        return new BrandResource($brand);
    }
}

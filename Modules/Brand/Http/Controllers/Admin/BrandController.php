<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Http\Requests\BrandCreateRequest;
use Modules\Brand\Http\Requests\BrandUpdateRequest;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Services\BrandStorage;
use Modules\Brand\Transformers\BrandResource;

class BrandController extends Controller
{
    public function __construct(
        protected BrandStorage $brandStorage,
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

    public function store(BrandCreateRequest $request)
    {
        $brand = $this->brandStorage->store(BrandDto::fromFormRequest($request));

        return new BrandResource($brand);
    }

    public function update(int $brand, BrandUpdateRequest $request)
    {
        $brandModel = $this->brandRepository->find($brand);

        $brandModel = $this->brandStorage->update($brandModel, (new BrandDto($request->validated()))->only(...$request->keys()));

        return new BrandResource($brandModel);
    }

    public function destroy(int $brand)
    {
        $brandModel = $this->brandRepository->find($brand);

        $this->brandStorage->delete($brandModel);

        return response()->noContent();
    }

}

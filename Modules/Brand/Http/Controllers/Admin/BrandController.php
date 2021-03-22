<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Http\Requests\BrandCreateRequest;
use Modules\Brand\Http\Requests\BrandUpdateRequest;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Services\BrandStorage;
use Modules\Brand\Transformers\BrandResource;

class BrandController extends Controller
{
    protected BrandStorage $brandStorage;

    protected BrandRepository $brandRepository;

    public function __construct(BrandStorage $brandStorage)
    {
        $this->brandStorage = $brandStorage;
    }

    public function index()
    {
        $brands = $this->brandRepository->all();

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
        $brandModel = Brand::query()->firstOrFail($brand);

        $item = $this->brandStorage->update($brandModel, BrandDto::fromFormRequest($request));

        return new BrandResource($item);
    }

    public function destroy(int $brand)
    {
        $brandModel = Brand::query()->firstOrFail($brand);

        abort_unless($this->brandStorage->delete($brandModel), 500, 'Не удалось удалить производителя');

        return response()->noContent();
    }

}

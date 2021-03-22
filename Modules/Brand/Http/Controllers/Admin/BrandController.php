<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Http\Requests\BrandRequest;
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

    public function store(BrandRequest $request)
    {
        $brand = $this->brandStorage->store(BrandDto::fromFormRequest($request));

        return new BrandResource($brand);
    }

    public function update(int $brand,BrandRequest $request)
    {
        $brandModel = $this->brandStorage->update($brand, BrandDto::fromFormRequest($request));

        return new BrandResource($brandModel);
    }

    public function destroy(int $brand)
    {
        abort_unless($this->brandStorage->delete($brand), 500, 'Не удалось удалить производителя');

        return response()->noContent();
    }

}

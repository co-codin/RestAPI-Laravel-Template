<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Http\Requests\BrandCreateRequest;
use Modules\Brand\Http\Requests\BrandUpdateRequest;
use Modules\Brand\Http\Resources\BrandResource;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Services\BrandStorage;

class BrandController extends Controller
{
    public function __construct(
        protected BrandStorage $brandStorage,
        protected BrandRepository $brandRepository
    ) {}

    public function store(BrandCreateRequest $request)
    {
        $brandDto = BrandDto::fromFormRequest($request);

        if (!$brandDto->assigned_by_id) {
            $brandDto->assigned_by_id = auth('custom-token')->id();
        }

        $brand = $this->brandStorage->store($brandDto);

        return new BrandResource($brand);
    }

    public function update(int $brand, BrandUpdateRequest $request)
    {
        $brandModel = $this->brandRepository->find($brand);

        $brandModel = $this->brandStorage->update($brandModel, BrandDto::fromFormRequest($request));

        return new BrandResource($brandModel);
    }

    public function destroy(int $brand)
    {
        $brandModel = $this->brandRepository->find($brand);

        $this->brandStorage->delete($brandModel);

        return response()->noContent();
    }
}

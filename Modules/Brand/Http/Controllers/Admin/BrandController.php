<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Http\Requests\BrandCreateRequest;
use Modules\Brand\Http\Requests\BrandUpdateRequest;
use Modules\Brand\Http\Resources\BrandResource;
use Modules\Brand\Models\Brand;
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
        $this->authorize('create', Brand::class);

        $brandDto = BrandDto::fromFormRequest($request);

        if (!$brandDto->assigned_by_id) {
            $brandDto->assigned_by_id = auth('sanctum')->id();
        }

        $brand = $this->brandStorage->store($brandDto);

        return new BrandResource($brand);
    }

    public function update(int $brand, BrandUpdateRequest $request)
    {
        $brand = $this->brandRepository->find($brand);

        $this->authorize('update', $brand);

        $brand = $this->brandStorage->update($brand, BrandDto::fromFormRequest($request));

        return new BrandResource($brand);
    }

    public function destroy(int $brand)
    {
        $brand = $this->brandRepository->find($brand);

        $this->authorize('delete', $brand);

        $this->brandStorage->delete($brand);

        return response()->noContent();
    }
}

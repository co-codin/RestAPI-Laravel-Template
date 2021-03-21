<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Http\Requests\BrandRequest;
use Modules\Brand\Services\BrandStorage;
use Modules\Brand\Transformers\BrandResource;

class BrandController extends Controller
{
    protected BrandStorage $brandStorage;

    public function __construct(BrandStorage $brandStorage)
    {
        $this->brandStorage = $brandStorage;
    }

    public function store(BrandRequest $request)
    {
        $brand = $this->brandStorage->store(BrandDto::fromFormRequest($request));

        return new BrandResource($brand);
    }

    public function update(int $brandId,BrandRequest $request)
    {
        $brand = $this->brandStorage->update($brandId, BrandDto::fromFormRequest($request));

        return new BrandResource($brand);
    }

    public function destroy(int $brandId)
    {
        if ($this->brandStorage->delete($brandId)) {
            return response()->json([], 204);
        } else {
            return response()->json([], 400);
        }
    }

}

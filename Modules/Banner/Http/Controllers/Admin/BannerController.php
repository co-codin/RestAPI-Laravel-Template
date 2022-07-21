<?php

namespace Modules\Banner\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Banner\Http\Requests\BannerCreateRequest;
use Modules\Banner\Http\Requests\BannersSortRequest;
use Modules\Banner\Http\Requests\BannerUpdateRequest;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Models\Banner;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Banner\Services\BannerStorage;

class BannerController extends Controller
{
    public function __construct(
        protected BannerStorage $bannerStorage,
        protected BannerRepository $bannerRepository
    ) {}

    public function store(BannerCreateRequest $request)
    {
        $this->authorize('create', Banner::class);

        return new BannerResource(
            $this->bannerStorage->store($request->validated())
        );
    }

    public function update(int $banner, BannerUpdateRequest $request)
    {
        $banner = $this->bannerRepository->find($banner);

        $this->authorize('update', $banner);

        $bannerModel = $this->bannerStorage->update($banner, $request->validated());

        return new BannerResource($bannerModel);
    }

    public function destroy(int $banner)
    {
        $banner = $this->bannerRepository->find($banner);

        $this->authorize('delete', $banner);

        $this->bannerStorage->delete($banner);

        return response()->noContent();
    }

    public function sort(BannersSortRequest $request)
    {
        $this->authorize('sort', Banner::class);

        $this->bannerStorage->sort($request->input('banners'));

        return response()->noContent();
    }
}

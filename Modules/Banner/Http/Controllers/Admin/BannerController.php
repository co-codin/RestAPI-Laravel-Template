<?php

namespace Modules\Banner\Http\Controllers\Admin;

use Modules\Banner\Http\Requests\BannerCreateRequest;
use Modules\Banner\Http\Requests\BannerUpdateRequest;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Banner\Services\BannerStorage;

class BannerController
{
    public function __construct(
        protected BannerStorage    $bannerStorage,
        protected BannerRepository $bannerRepository
    ) {}

    public function store(BannerCreateRequest $request)
    {
        return new BannerResource(
            $this->bannerStorage->store($request->validated())
        );
    }

    public function update(int $banner, BannerUpdateRequest $request)
    {
        $bannerModel = $this->bannerRepository->find($banner);

        $bannerModel = $this->bannerStorage->update($bannerModel, $request->validated());

        return new BannerResource($bannerModel);
    }

    public function destroy(int $banner)
    {
        $bannerModel = $this->bannerRepository->find($banner);

        $this->bannerStorage->delete($bannerModel);

        return response()->noContent();
    }
}

<?php

namespace Modules\Banner\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Banner\Http\Requests\BannerCreateRequest;
use Modules\Banner\Http\Requests\BannersSortRequest;
use Modules\Banner\Http\Requests\BannerUpdateRequest;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Models\Banner;
use Modules\Banner\Services\BannerStorage;

class BannerController extends Controller
{
    public function __construct(
        protected BannerStorage    $bannerStorage
    ) {
        $this->authorizeResource(Banner::class, 'banner');
    }

    public function store(BannerCreateRequest $request)
    {
        return new BannerResource(
            $this->bannerStorage->store($request->validated())
        );
    }

    public function update(Banner $banner, BannerUpdateRequest $request)
    {
        $bannerModel = $this->bannerStorage->update($banner, $request->validated());

        return new BannerResource($bannerModel);
    }

    public function destroy(Banner $banner)
    {
        $this->bannerStorage->delete($banner);

        return response()->noContent();
    }

    public function sort(BannersSortRequest $request)
    {
        $this->bannerStorage->sort($request->input('banners'));

        return response()->noContent();
    }
}

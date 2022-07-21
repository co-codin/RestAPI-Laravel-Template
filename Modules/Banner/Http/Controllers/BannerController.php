<?php

namespace Modules\Banner\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Models\Banner;
use Modules\Banner\Repositories\BannerRepository;

class BannerController extends Controller
{
    public function __construct(
        protected BannerRepository $bannerRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Banner::class);

        $banners = $this->bannerRepository->jsonPaginate();

        return BannerResource::collection($banners);
    }

    public function show(int $banner)
    {
        $banner = $this->bannerRepository->find($banner);

        $this->authorize('view', $banner);

        return new BannerResource($banner);
    }
}

<?php

namespace Modules\Banner\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Repositories\BannerRepository;

class BannerController extends Controller
{
    public function __construct(
        protected BannerRepository $bannerRepository
    ) {}

    public function index()
    {
        $banners = $this->bannerRepository->jsonPaginate();

        return BannerResource::collection($banners);
    }

    public function show(int $banner)
    {
        $bannerModel = $this->bannerRepository->find($banner);

        return new BannerResource($bannerModel);
    }
}

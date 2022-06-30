<?php

namespace App\Http\Controllers;

use App\Http\Resources\HomePageResource;
use App\Services\HomePageService;

class HomePageController extends Controller
{
    public function __construct(
        protected HomePageService $homePageService
    ) {}

    public function index()
    {
        return HomePageResource::collection($this->homePageService->getBrands());
    }
}

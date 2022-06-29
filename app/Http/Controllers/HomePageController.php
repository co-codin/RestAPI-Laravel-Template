<?php

namespace App\Http\Controllers;

use App\Services\HomePageService;

class HomePageController extends Controller
{
    public function __construct(
        protected HomePageService $homePageService
    ) {}

    public function index()
    {
        return $this->homePageService->getBrands();
    }
}

<?php

namespace App\Http\Controllers\Page;

use App\Services\Page\HomePageService;
use Illuminate\Support\Facades\Cache;

class HomePageController
{
    public function __construct(
        protected HomePageService $homePageService
    ) {}

    public function index()
    {
        return Cache::remember(
            'page-home-data',
            now()->addDay(),
            fn() => $this->homePageService->getData()
        );
    }
}

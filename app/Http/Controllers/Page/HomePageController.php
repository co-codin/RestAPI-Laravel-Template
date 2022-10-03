<?php

namespace App\Http\Controllers\Page;

use App\Services\Page\HomePageService;

class HomePageController
{
    public function __construct(
        protected HomePageService $homePageService
    ) {}

    public function index()
    {
        return $this->homePageService->getData();
        // banners
//        banners(
//            where: {
//                AND: [{ column: IS_ENABLED, operator: EQ, value: true }, { column: PAGE, operator: EQ, value: "home-page" }]
//            }
//            orderBy: [{ column: POSITION, order: ASC }]
//        ) {
//        data {
//            url
//                images {
//                desktop
//                    tablet
//                    mobile
//                }
//            }
//        }

        // hot
        // covid
        // brands
        // made in russia
        // publications
        // news
    }
}

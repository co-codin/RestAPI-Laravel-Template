<?php

namespace App\Services;

use App\Enums\Status;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Repositories\ProductRepository;
use Modules\Publication\Repositories\PublicationRepository;

class HomePageService
{
    const COVID_PROPERTY_ID = 259;

    public function __construct(
        protected ProductRepository $productRepository,
        protected BrandRepository $brandRepository,
        protected BannerRepository $bannerRepository,
        protected PublicationRepository $publicationRepository
    ) {}

    public function all()
    {
//        $productsHotBuilder = $this->getProductsHot();
//        $productsRussiaBuilder = $this->getProductsRussia();
//        $productsCovidBuilder = $this->getProductsCovid();
//
//        return $productsHotBuilder->merge([
//            $productsRussiaBuilder, $productsCovidBuilder,
//        ])->all();
    }

    public function getProductsHot()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query->withMainVariation()->hot(true)->fromCovid(false);
            })
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews'])
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                'group_id' => ProductGroup::IMPOSSIBLE
            ])
            ->take(20)
            ->all();
    }


    public function getProductsRussia()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query->withMainVariation();
            })
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews'])
            ->findWhere([
                'status' => Status::ACTIVE,
                'country_id' => 13, // Russia
                'group_id' => ProductGroup::IMPOSSIBLE
            ])
            ->take(20)
            ->all();
    }

    public function getProductsCovid()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query->withMainVariation()->fromCovid(true);
            })
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews'])
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                'group_id' => ProductGroup::IMPOSSIBLE
            ])
            ->take(20)
            ->all();
    }

    public function getBrands()
    {
        return $this->brandRepository
            ->orderBy('position')
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
            ])
            ->all();
    }

    public function getBanners()
    {
        return $this->bannerRepository
            ->orderBy('position')
            ->findWhere([
                'is_enabled' => true,
                'page' => 'home-page'
            ])
            ->all();
    }

    public function getPublications()
    {

    }

    public function getNews()
    {

    }
}

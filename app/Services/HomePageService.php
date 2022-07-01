<?php

namespace App\Services;

use App\Enums\Status;
use App\Repositories\Criteria\ProductHomePageCriteria;
use Illuminate\Support\Arr;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Banner\Repositories\Criteria\BannerHomePageCriteria;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Repositories\Criteria\BrandHomePageCriteria;
use Modules\News\Repositories\Criteria\NewsHomePageCriteria;
use Modules\News\Repositories\NewsRepository;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Repositories\ProductRepository;
use Modules\Publication\Repositories\Criteria\PublicationHomePageCriteria;
use Modules\Publication\Repositories\PublicationRepository;

class HomePageService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected BrandRepository $brandRepository,
        protected BannerRepository $bannerRepository,
        protected PublicationRepository $publicationRepository,
        protected NewsRepository $newsRepository
    ) {
        $this->productRepository
            ->resetCriteria()
            ->pushCriteria(ProductHomePageCriteria::class);
    }

    public function all()
    {
        return [
            'productsHot' => $this->getProductsHot(),
            'productsRussia' => $this->getProductsRussia(),
            'productsCovid' => $this->getProductsCovid(),
            'homeBrands' => $this->getBrands(),
            'publications' => $this->getPublications(),
            'news' => $this->getNews(),
            'banners' => $this->getBanners(),
        ];
    }

    public function getProductsHot()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->hot(true)
                    ->fromCovid(false)
                    ->withMainVariation()
                    ;
            })
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                ['group_id', '!=', ProductGroup::IMPOSSIBLE],
            ])
            ->take(20)
            ->map(function ($product) {
                return $this->transformProduct($product);
            })
            ;
    }


    public function getProductsRussia()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query->withMainVariation();
            })
            ->findWhere([
                'status' => Status::ACTIVE,
                'country_id' => 13, // Russia
                ['group_id', '!=', ProductGroup::IMPOSSIBLE],
            ])
            ->take(20)
            ->map(function ($product) {
                return $this->transformProduct($product);
            });
    }

    public function getProductsCovid()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query->withMainVariation()->fromCovid(true);
            })
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                ['group_id', '!=', ProductGroup::IMPOSSIBLE],
            ])
            ->take(20)
            ->map(function ($product) {
                return $this->transformProduct($product);
            });
    }

    public function getBrands()
    {
        return $this->brandRepository
            ->resetCriteria()
            ->pushCriteria(BrandHomePageCriteria::class)
            ->orderBy('position')
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
            ])
            ;
    }

    public function getBanners()
    {
        return $this->bannerRepository
            ->resetCriteria()
            ->pushCriteria(BannerHomePageCriteria::class)
            ->orderBy('position')
            ->findWhere([
                'is_enabled' => true,
                'page' => 'home-page'
            ])
            ;
    }

    public function getPublications()
    {
        return $this->publicationRepository
            ->resetCriteria()
            ->pushCriteria(PublicationHomePageCriteria::class)
            ->orderBy('published_at', 'desc')
            ->findWhere([
                'is_enabled' => true
            ])
            ->take(4)
            ;
    }

    public function getNews()
    {
        return $this->newsRepository
            ->resetCriteria()
            ->pushCriteria(NewsHomePageCriteria::class)
            ->orderBy('published_at', 'desc')
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE
            ])
            ->take(4)
            ;
    }

    protected function transformProduct($product)
    {
        if ($product->productReviews) {

            $rating = Arr::pluck($product->productReviews[0]->ratings ?? [], 'rate');
            $product->rating = !empty($rating) ? round(array_sum($rating) / count($rating), 1) : 0;
        }

        return $product;
    }
}

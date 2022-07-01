<?php

namespace App\Services;

use App\Enums\Status;
use App\Repositories\Criteria\ProductHomePageCriteria;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Brand\Repositories\BrandRepository;
use Modules\News\Repositories\NewsRepository;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Repositories\ProductRepository;
use Modules\Publication\Repositories\PublicationRepository;
use Modules\Review\Models\ProductReview;

class HomePageService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected BrandRepository $brandRepository,
        protected BannerRepository $bannerRepository,
        protected PublicationRepository $publicationRepository,
        protected NewsRepository $newsRepository
    ) {}

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
            ->resetCriteria()
            ->pushCriteria(ProductHomePageCriteria::class)
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
//            ->map(function ($product) {
//                return $this->transformProduct($product);
//            })
            ;
    }


    public function getProductsRussia()
    {
        return $this->productRepository
            ->scopeQuery(function ($query) {
                return $query->withMainVariation();
            })
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews', 'productAnswers'])
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
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews', 'productAnswers'])
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
            ->orderBy('position')
            ->with('products')
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
            ])
            ->map(function ($brand) {
                $brand->productCount = count($brand->products);

                return $brand->only('id', 'name', 'slug', 'productCount');
            });
    }

    public function getBanners()
    {
        return $this->bannerRepository
            ->orderBy('position')
            ->findWhere([
                'is_enabled' => true,
                'page' => 'home-page'
            ])
            ->map(function ($banner) {
                return $banner->only('url', 'images');
            });
    }

    public function getPublications()
    {
        return $this->publicationRepository
            ->orderBy('published_at', 'desc')
            ->findWhere([
                'is_enabled' => true
            ])
            ->take(4)
            ->map(function ($publication) {
                return $publication->only('id', 'name', 'source', 'url', 'logo', 'published_at');
            });
    }

    public function getNews()
    {
        return $this->newsRepository
            ->orderBy('published_at', 'desc')
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE
            ])
            ->take(4)
            ->map(function ($news) {
                return $news->only('id', 'short_description', 'name', 'slug', 'image', 'published_at', 'view_num');
            });
    }

    protected function transformProduct($product)
    {

        if ($product->productReviews) {
            dd(
                count($product->productReviews)
            );
            $product->productReviewCount = count($product->productReviews->ratings);

//            $rating = $product->productReviews
//                ->avg(fn(ProductReview $productReview) => $productReview->ratings_avg);
//
//            $product->rating = !is_null($rating) ? floor($rating) : 0;
        }

        $product->productAnswerCount = count($product->productAnswers);

        return $product;

//        return $product->only(
//            'id', 'name', 'article', 'image', 'slug', 'group_id',
//            'brand', 'stockType', 'category', 'images', 'productReviews',
//            'rating', 'productReviewCount', 'productAnswerCount'
//        );
    }
}

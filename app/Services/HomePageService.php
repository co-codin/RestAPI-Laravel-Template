<?php

namespace App\Services;

use App\Enums\Status;
use Illuminate\Support\Arr;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Brand\Repositories\BrandRepository;
use Modules\News\Repositories\NewsRepository;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Repositories\ProductRepository;
use Modules\Publication\Repositories\PublicationRepository;

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
            ->scopeQuery(function ($query) {
                $query->hot(true);
                $query->fromCovid(false);
                $query->withMainVariation();

                return $query;
            })
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews'])
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                'group_id' => ProductGroup::PRIORITY
            ])
            ->take(20)
            ->map(function ($product) {
                return $this->transformProduct($product);
            });
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
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews'])
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                'group_id' => ProductGroup::IMPOSSIBLE
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
            ->all();
    }

    public function getPublications()
    {
        return $this->publicationRepository
            ->orderBy('published_at', 'desc')
            ->findWhere([
                'is_enabled' => true
            ])
            ->take(4)
            ->all();
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
            ->all();
    }

    protected function transformProduct($product)
    {
        $product->brand = $product->brand->only('name');

        if ($product->stockType) {
            $product->stockType = $product->stockType->only('value');
        }

        $product->category = $product->category->only('name');
        $product->images = $product->images->only('image');

        if ($product->productReviews) {
            $product->productReviews = $product->productReviews->only('ratings');
        }


        return $product->only(
            'id', 'name', 'article', 'image', 'slug', 'group_id',
            'brand', 'stockType', 'category', 'images', 'productReviews',
            'rating', 'productReviewCount', 'productAnswerCount'
        );
    }
}

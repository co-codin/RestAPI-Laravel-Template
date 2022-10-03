<?php

namespace App\Services\Page;

use Modules\Banner\Enums\BannerPage;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Brand\Repositories\BrandRepository;
use Modules\News\Http\Resources\NewsResource;
use Modules\News\Repositories\NewsRepository;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Publication\Http\Resources\PublicationResource;
use Modules\Publication\Repositories\PublicationRepository;

class HomePageService
{
    public function __construct(
        protected BannerRepository $bannerRepository,
        protected ProductRepository $productRepository,
        protected BrandRepository $brandRepository,
        protected PublicationRepository $publicationRepository,
        protected NewsRepository $newsRepository
    ) {}

    public function getData(): array
    {
        return [
            'banners' => $this->banners(),
            'news' => $this->news(),
            'publications' => $this->publications(),
            'hot_products' => $this->hotProducts(),
            'covid_products' => $this->covidProducts(),
            'made_in_russia_products' => $this->madeInRussiaProducts(),
        ];
    }

    public function banners()
    {
        $banners = $this->bannerRepository
            ->getBannersByPage(BannerPage::HOME_PAGE);

        return BannerResource::collection($banners);
    }

    public function news()
    {
        $news = $this->newsRepository->getHomeNews();

        return NewsResource::collection($news);
    }

    public function publications()
    {
        $publications = $this->publicationRepository->getHomePublications();

        return PublicationResource::collection($publications);
    }

    public function hotProducts()
    {
        $products = $this->productRepository->getHomeHotProducts();

        return ProductResource::collection($products);
    }

    public function covidProducts()
    {
        $products = $this->productRepository->getHomeCovidProducts();

        return ProductResource::collection($products);
    }

    public function madeInRussiaProducts()
    {
        $products = $this->productRepository->getHomeMadeInRussiaProducts();

        return ProductResource::collection($products);
    }
}

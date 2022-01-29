<?php


namespace Modules\Export\Services\Generators\Tiu;


use Illuminate\Database\Eloquent\Model;
use Modules\Export\Models\Export;
use Modules\Export\Services\Generators\FeedGeneratorInterface;
use Bukashk0zzz\YmlGenerator\Generator;
use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Modules\Export\Services\Generators\Tiu\Entities\CategoryGenerator;
use Modules\Export\Services\Generators\Tiu\Entities\CurrencyGenerator;
use Modules\Export\Services\Generators\Tiu\Entities\OffersGenerator;

class TiuFeedGenerator implements FeedGeneratorInterface
{
    public function __construct(
        protected CurrencyGenerator $currencyGenerator,
        protected CategoryGenerator $categoryGenerator,
        protected OffersGenerator $offersGenerator,
        protected Settings $settings,
        protected ShopInfo $shopInfo
    ) {}

    public function generate(Export|Model $export): void
    {
        $settings = $this->settings
            ->setOutputFile(storage_path('app/public/feeds') . '/' . $export->filename . '.xml')
            ->setEncoding('UTF-8');

        $shopInfo = $this->shopInfo
            ->setName(config('app.name'))
            ->setCompany(config('app.name'))
            ->setUrl(config('app.site_url'));

        $currencies = $this->currencyGenerator->getCurrencies();
        $categories = $this->categoryGenerator->getCategories();
        $offers = $this->offersGenerator->getOffers($export->filter);

        (new Generator($settings))->generate($shopInfo, $currencies, $categories, $offers);
    }
}

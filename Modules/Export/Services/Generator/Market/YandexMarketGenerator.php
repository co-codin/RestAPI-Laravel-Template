<?php


namespace Modules\Export\Services\Generator\Market;


use Bukashk0zzz\YmlGenerator\Generator;
use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\CategoryGenerator;
use Modules\Export\Services\Generator\CurrencyGenerator;
use Modules\Export\Services\Generator\OffersGenerator;

class YandexMarketGenerator implements GeneratorInterface
{
    public function __construct(
        protected CurrencyGenerator $currencyGenerator,
        protected CategoryGenerator $categoryGenerator,
        protected OffersGenerator $offersGenerator,
        protected Settings $settings,
        protected ShopInfo $shopInfo
    ) {}

    public function generate(array $parameters)
    {
        $settings = $this->settings
            ->setOutputFile(storage_path('app/feeds') . '/' . Arr::get($parameters, 'filename') . '.xml')
            ->setEncoding('UTF-8');

        $shopInfo = $this->shopInfo
            ->setName('MedeqStars.ru')
            ->setCompany('Best online seller Inc.')
            ->setUrl('https://medeqstars.ru');

        $currencies = $this->currencyGenerator->getCurrencies();

        $categories = $this->categoryGenerator->getCategories();

        $offers = $this->offersGenerator->getOffers($parameters);

        (new Generator($settings))->generate(
            $shopInfo,
            $currencies,
            $categories,
            $offers
        );
    }
}

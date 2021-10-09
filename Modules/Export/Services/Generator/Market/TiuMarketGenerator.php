<?php


namespace Modules\Export\Services\Generator\Market;


use Bukashk0zzz\YmlGenerator\Generator;
use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\CategoryGenerator;
use Modules\Export\Services\Generator\CurrencyGenerator;
use Modules\Export\Services\Generator\OffersGenerator;

class TiuMarketGenerator implements GeneratorInterface
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
        $filename = Arr::get($parameters, 'filename');

        $settings = $this->settings
            ->setOutputFile(storage_path('app/feeds') . '/' . $filename . '.xml')
            ->setEncoding('UTF-8');

        $shopInfo = $this->shopInfo
            ->setName(config('app.name'))
            ->setCompany(config('services.tiu.company_name'))
            ->setUrl(config('app.url'));

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

    public function transform($data)
    {

    }
}

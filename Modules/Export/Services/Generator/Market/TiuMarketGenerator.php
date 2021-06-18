<?php


namespace Modules\Export\Services\Generator\Market;


use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\Side\CategoryGenerator;
use Modules\Export\Services\Generator\Side\CurrencyGenerator;
use Modules\Export\Services\Generator\Side\OffersGenerator;

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
            ->setOutputFile(public_path() . '/uploads/' . $filename . '.xml')
            ->setEncoding('UTF-8');

        $shopInfo = $this->shopInfo
            ->setName(config('app.name'))
            ->setCompany(config('services.tiu.company_name'))
            ->setUrl(config('app.url'));

        $currencies = $this->currencyGenerator->getCurrencies();
        $categories = $this->categoryGenerator->getCategories();
        $offers = $this->offersGenerator->getOffers($parameters);
    }

    public function transform($data)
    {

    }
}

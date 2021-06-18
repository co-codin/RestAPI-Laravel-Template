<?php


namespace Modules\Export\Services\Generator\Market;


use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Modules\Export\Services\Generator\Side\CategoryGenerator;
use Modules\Export\Services\Generator\Side\CurrencyGenerator;
use Modules\Export\Services\Generator\Side\OffersGenerator;

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

    }

    public function transform($data)
    {

    }
}

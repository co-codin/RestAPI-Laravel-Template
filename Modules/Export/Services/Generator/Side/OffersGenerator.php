<?php


namespace Modules\Export\Services\Generator\Side;


use Bukashk0zzz\YmlGenerator\Model\Currency as CurrencyYaml;
use Illuminate\Support\Str;

class OffersGenerator
{
    public function getCurrencies(): array
    {
        $currencies = [];

        foreach ($this->getCurrencyEntities() as $currency) {
            $currencies[] = (new CurrencyYaml())
                ->setId(Str::upper($currency->iso_code))
                ->setRate($currency->rate);
        }

        return $currencies;
    }
}

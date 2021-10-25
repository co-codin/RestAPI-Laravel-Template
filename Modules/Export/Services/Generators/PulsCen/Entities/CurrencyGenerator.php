<?php


namespace Modules\Export\Services\Generators\PulsCen\Entities;


use Bukashk0zzz\YmlGenerator\Model\Currency as CurrencyYaml;
use Illuminate\Support\Str;
use Modules\Currency\Models\Currency;

class CurrencyGenerator
{
    public function getCurrencies(): array
    {
        $currencies = [];
        $currencyEntities = Currency::query()->get();

        foreach ($currencyEntities as $currency) {
            $currencies[] = (new CurrencyYaml())
                ->setId(Str::upper($currency->iso_code))
                ->setRate($currency->rate);
        }

        return $currencies;
    }
}

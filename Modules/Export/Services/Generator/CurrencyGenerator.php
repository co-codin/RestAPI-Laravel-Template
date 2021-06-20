<?php


namespace Modules\Export\Services\Generator;


use Bukashk0zzz\YmlGenerator\Model\Currency as CurrencyYaml;
use Illuminate\Support\Str;
use Modules\Currency\Models\Currency;

class CurrencyGenerator
{
    public function getCurrencies(): array
    {
        $currencies = [];

        foreach (Currency::query()->get() as $currency) {
            $currencies[] = (new CurrencyYaml())
                ->setId(Str::upper($currency->iso_code))
                ->setRate($currency->rate);
        }

        return $currencies;
    }
}

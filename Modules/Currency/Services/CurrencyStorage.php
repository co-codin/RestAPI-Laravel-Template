<?php


namespace Modules\Currency\Services;


use Modules\Currency\Dto\CurrencyDto;
use Modules\Currency\Models\Currency;

class CurrencyStorage
{
    public function store(CurrencyDto $currencyDto)
    {
        return Currency::query()->create($currencyDto->toArray());
    }

    public function update(Currency $currency, CurrencyDto $currencyDto)
    {
        if (!$currency->update($currencyDto->toArray())) {
            throw new \LogicException('can not update currency.');
        }
        return $currency;
    }

    public function delete(Currency $currency)
    {
        if (!$currency->delete()) {
            throw new \LogicException('can not delete currency.');
        }
    }
}

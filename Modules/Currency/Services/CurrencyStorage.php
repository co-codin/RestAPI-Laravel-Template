<?php


namespace Modules\Currency\Services;


use Illuminate\Support\Facades\Artisan;
use Modules\Currency\Dto\CurrencyDto;
use Modules\Currency\Models\Currency;

class CurrencyStorage
{
    public function __construct()
    {
        Artisan::call('currency:parse');
    }

    public function store(CurrencyDto $currencyDto)
    {
        $this->truncateMainColumn($currencyDto->is_main);

        return Currency::query()->create($currencyDto->toArray());
    }

    public function update(Currency $currency, CurrencyDto $currencyDto)
    {
        $this->truncateMainColumn($currencyDto->is_main);

        if (!$currency->update($currencyDto->toArray())) {
            throw new \LogicException('can not update currency.');
        }
        return $currency;
    }

    public function delete(Currency $currency)
    {
        if (!$currency->is_main) {
            $currency->delete();
        }
    }

    protected function truncateMainColumn($isMain)
    {
        if ($isMain) {
            Currency::query()->update(['is_main', false]);
        }
    }
}

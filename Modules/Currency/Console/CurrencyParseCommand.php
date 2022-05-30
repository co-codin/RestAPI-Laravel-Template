<?php

namespace Modules\Currency\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Currency\Models\Currency;

class CurrencyParseCommand extends Command
{
    protected $signature = 'currency:parse';

    protected $description = 'Parse currency from cb rf';

    public function handle()
    {
        $rates = Http::get('https://www.cbr-xml-daily.ru/daily_json.js')
            ->throw()
            ->collect('Valute')
            ->keyBy('CharCode');

        Currency::all()->each(function (Currency $currency) use ($rates) {

            if ($rate = $rates->get($currency->iso_code)) {
                $value = $rate['Value'];
                if ($currency->iso_code === 'CNY') {
                    $value = $value / 10;
                }
                $currency->rate = round($value, 2);
                $currency->save();
            }
        });
    }
}

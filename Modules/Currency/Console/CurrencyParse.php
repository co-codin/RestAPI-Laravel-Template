<?php

namespace Modules\Currency\Console;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Currency\Models\Currency;

class CurrencyParse extends Command
{
    protected $signature = 'parse:currency';

    protected $description = 'Parse currency from cb rf';

    /**
     * Execute the console command.
     * @param Client $client
     * @throws \GuzzleHttp\Exception\GuzzleException|\JsonException
     */
    public function handle(Client $client)
    {
        $response = $client->request('get', 'https://www.cbr-xml-daily.ru/daily_json.js');
        $data = json_decode(
            $response->getBody(),
            JSON_OBJECT_AS_ARRAY,
            512,
            JSON_THROW_ON_ERROR
        );
        $rates = collect(Arr::get($data, 'Valute', []));

        $currencies = Currency::all();

        $rates->each(function($rate, $key) use ($currencies) {
            if(!$currency = $currencies->where('code', Str::lower($key))->first()) {
                return;
            }
            $currency->rate = round($rate['Value'], 2);
            $currency->save();
        });
    }
}

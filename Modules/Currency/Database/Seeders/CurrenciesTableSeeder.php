<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Currency\Models\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'Рубль',
                'iso_code' => 'RUB',
                'rate' => 1,
            ],
            [
                'name' => 'Доллар',
                'iso_code' => 'USD',
                'rate' => 65.72,
            ],
            [
                'name' => 'Евро',
                'iso_code' => 'EUR',
                'rate' => 72.58,
            ],
        ];
        foreach($currencies as $currency) {
            Currency::create($currency);
        }
    }
}

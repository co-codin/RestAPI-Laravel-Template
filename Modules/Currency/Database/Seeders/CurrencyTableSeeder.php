<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Currency\Models\Currency;

class CurrencyTableSeeder extends Seeder
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
                'code' => 'rub',
                'rate' => 1,
            ],
            [
                'name' => 'Доллар',
                'code' => 'usd',
                'rate' => 65.72,
            ],
            [
                'name' => 'Евро',
                'code' => 'eur',
                'rate' => 72.58,
            ],
        ];
        foreach($currencies as $currency) {
            Currency::create($currency);
        }
    }
}

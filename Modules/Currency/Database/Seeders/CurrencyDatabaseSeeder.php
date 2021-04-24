<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrencyTableSeeder::class);
    }
}

<?php

namespace Modules\Brand\Database\Seeders;

use Illuminate\Database\Seeder;

class BrandDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(BrandsTableSeeder::class);
    }
}

<?php

namespace Modules\Banner\Database\Seeders;

use Illuminate\Database\Seeder;

class BannerDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(BannersTableSeeder::class);
    }
}

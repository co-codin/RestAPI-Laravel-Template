<?php

namespace Modules\Seo\Database\Seeders;

use Illuminate\Database\Seeder;

class SeoDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(SeoTableSeeder::class);
    }
}

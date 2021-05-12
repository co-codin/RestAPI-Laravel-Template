<?php

namespace Modules\Seo\Database\Seeders;

use Illuminate\Database\Seeder;

class CanonicalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CanonicalTableSeeder::class);
    }
}

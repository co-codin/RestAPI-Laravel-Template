<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PagesTableSeeder::class);
    }
}

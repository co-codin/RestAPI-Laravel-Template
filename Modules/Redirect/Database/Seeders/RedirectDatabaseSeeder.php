<?php

namespace Modules\Redirect\Database\Seeders;

use Illuminate\Database\Seeder;

class RedirectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RedirectsTableSeeder::class);
    }
}

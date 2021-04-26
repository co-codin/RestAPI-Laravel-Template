<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;

class PropertyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PropertiesTableSeeder::class);
    }
}

<?php

namespace Modules\Publication\Database\Seeders;

use Illuminate\Database\Seeder;

class PublicationDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PublicationsTableSeeder::class);
    }
}

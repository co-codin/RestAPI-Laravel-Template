<?php

namespace Modules\Cabinet\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cabinet\Models\Cabinet;

class CabinetsTableSeeder extends Seeder
{
    public function run()
    {
        Cabinet::factory()->count(10)->create();
    }
}

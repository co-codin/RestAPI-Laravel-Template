<?php

namespace Modules\Publication\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Publication\Models\Publication;

class PublicationsTableSeeder extends Seeder
{
    public function run()
    {
        Publication::factory()->count(30)->create();
    }
}

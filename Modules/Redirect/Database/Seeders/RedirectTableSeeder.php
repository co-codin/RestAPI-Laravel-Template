<?php

namespace Modules\Redirect\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Redirect\Models\Redirect;

class RedirectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Redirect::factory()->count(10)->create();
    }
}

<?php

namespace Modules\News\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\News\Models\News;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::factory()->count(50)->create();
    }
}

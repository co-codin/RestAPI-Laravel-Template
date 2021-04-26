<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
    }
}

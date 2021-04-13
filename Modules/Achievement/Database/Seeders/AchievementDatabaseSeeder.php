<?php

namespace Modules\Achievement\Database\Seeders;

use Illuminate\Database\Seeder;

class AchievementDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AchievementTableSeeder::class);
    }
}

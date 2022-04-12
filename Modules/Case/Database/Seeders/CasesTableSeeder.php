<?php

namespace Modules\Case\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Case\Models\CaseModel;

class CasesTableSeeder extends Seeder
{
    public function run()
    {
        CaseModel::factory()->count(30)->create();
    }

}

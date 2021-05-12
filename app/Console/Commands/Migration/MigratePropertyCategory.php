<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Achievement\Models\Achievement;

class MigratePropertyCategory extends Command
{
    protected $signature = 'migrate:property_category';

    protected $description = 'Migrate property category';

    public function handle()
    {
        $propertyCategories = DB::connection('old_medeq_mysql')
            ->table('property_categories')
            ->get();

        foreach ($propertyCategories as $propertyCategory) {
            DB::table('property_category')->insert(
                (array) $propertyCategory
            );
        }
    }
}

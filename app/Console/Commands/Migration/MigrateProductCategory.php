<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateProductCategory extends Command
{
    protected $signature = 'migrate:product_category';

    protected $description = 'Migrate product category';

    public function handle()
    {
        $oldProductCategories = DB::connection('old_medeq_mysql')->table('product_categories')->get();

        

    }
}

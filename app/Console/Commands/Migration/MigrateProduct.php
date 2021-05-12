<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;

class MigrateProduct extends Command
{
    protected $signature = 'migrate:product';

    protected $description = 'Migrate product';

    public function handle()
    {
        $oldProducts = DB::connection('old_medeq_mysql')->table('products')->get();

        foreach ($oldProducts as $oldProduct) {
            Product::query()->insert(
                $this->transform($oldProduct)
            );
        }
    }

    protected function transform($item)
    {
        return [

        ];
    }
}

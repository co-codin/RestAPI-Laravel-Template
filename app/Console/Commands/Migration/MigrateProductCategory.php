<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductCategory;

class MigrateProductCategory extends Command
{
    protected $signature = 'migrate:product_category';

    protected $description = 'Migrate product category';

    public function handle()
    {
        Model::unguard();

        $oldProductCategories = DB::connection('old_medeq_mysql')->table('product_categories')->get();

        foreach ($oldProductCategories as $oldProductCategory) {
            ProductCategory::query()->insert(
                $this->transform($oldProductCategory)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'product_id' => $item->product_id,
            'category_id' => $item->category_id,
            'is_main' => $item->is_main === 1,
        ];
    }
}

<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductVariation;

class MigrateProductVariation extends Command
{
    protected $signature = 'migrate:product_variation';

    protected $description = 'Migrate product variation';

    public function handle()
    {
        $oldProductVariations = DB::connection('old_medeq_mysql')->table('product_variations')->get();

        foreach ($oldProductVariations as $oldProductVariation) {
            ProductVariation::query()->insert(
                $this->transform($oldProductVariation)
            );
        }
    }

    protected function transform($item)
    {
        return [

        ];
    }
}

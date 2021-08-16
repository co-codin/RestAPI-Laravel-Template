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
            'id' => $item->id,
            'product_id' => $item->product_id,
            'name' => $item->title,
            'price' => $item->price,
            'previous_price' => $item->old_price,
            'currency_id' => $item->currency_id,
            'is_price_visible' => $item->is_show_price === 1,
            'is_enabled' => $item->status === 1,
            'availability' => $item->in_stock,
            'stock_type' => $item->stock_type,
        ];
    }
}

<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Product\Enums\ProductVariationCondition;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;

class MigrateProductVariation extends Command
{
    protected $signature = 'migrate:product_variation';

    protected $description = 'Migrate product variation';

    public function handle()
    {
        Model::unguard();

        $oldProductVariations = DB::connection('old_medeq_mysql')->table('product_variations')->get();

        foreach ($oldProductVariations as $oldProductVariation) {
            ProductVariation::query()->insert(
                $this->transform($oldProductVariation)
            );
        }
    }

    protected function transform($item)
    {
        if($item->stock_type) {
            Product::where('id', $item->product_id)
                ->update(['stock_type_id' => FieldValue::query()->firstOrCreate(['value' => $item->stock_type])->id]);
        }

        return [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'name' => $item->title,
            'price' => $item->price ,
            'previous_price' => $item->old_price,
            'currency_id' => $item->currency_id,
            'is_price_visible' => $item->is_show_price === 1,
            'is_enabled' => $item->status === 1,
            'availability' => $item->in_stock,
            'condition_id' => FieldValue::query()->firstOrCreate(['value' => ProductVariationCondition::getDescription($item->type_id)])->id,
        ];
    }
}

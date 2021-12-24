<?php

namespace Modules\Product\Console;

use App\Enums\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Collection as SupportCollection;

class ProductAnalogSearchCommand extends Command
{
    protected $signature = 'search:product-analogs';

    protected $description = 'Search product analogs';

    public function handle(): void
    {
        \DB::table('product_property as pp')
            ->select(['pp.product_id', 'pp.property_id', 'pp.field_value_ids'])
            ->join('products as p', 'p.id', '=', 'pp.product_id')
            ->where('p.status', Status::ACTIVE)
            ->where('p.is_manually_analogs', false)
            ->orderBy('pp.product_id')
            ->chunk(2000, function (SupportCollection $properties) {
                $grouped = $properties->groupBy('product_id');

                foreach ($grouped as $productId => $productProperties) {
                    $analogs = \DB::table('product_property as pp')
                        ->select([
                            'pp.product_id as analog_id',
                            \DB::raw('COUNT(*) as total'),
                            \DB::raw('ROW_NUMBER() OVER(ORDER BY COUNT(*) DESC) as position'),
                        ])
                        ->join('products as p', 'p.id', '=', 'pp.product_id')
                        ->where('pp.product_id', '!=', $productId)
                        ->where('p.status', Status::ACTIVE)
                        ->where('p.is_manually_analogs', false);

                    foreach ($productProperties as $property) {
                        $analogs = $analogs
                            ->orWhere(function ($query) use ($property) {
                                $query
                                    ->where('pp.property_id', $property->property_id)
                                    ->where('pp.field_value_ids', $property->field_value_ids);
                            });
                    }

                    $analogs = $analogs
                        ->groupBy('analog_id')
                        ->orderByDesc('total')
                        ->limit(12)
                        ->get();

                    $analogsData = $analogs->map(function (object $analogData) use ($productId) {
                        return [
                            'product_id' => $productId,
                            'analog_id' => $analogData->analog_id,
                            'position' => $analogData->position,
                        ];
                    });

                    \Db::table('product_analogs')->insert($analogsData->toArray());
                }
            });
    }
}

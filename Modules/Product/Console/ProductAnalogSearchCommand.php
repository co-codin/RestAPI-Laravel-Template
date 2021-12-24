<?php

namespace Modules\Product\Console;

use App\Enums\Status;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection as SupportCollection;

class ProductAnalogSearchCommand extends Command
{
    const COUNT_ANALOGS = 12;

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
                        ->where('p.is_manually_analogs', false)
                        ->where(function (Builder $query) use ($productProperties) {
                            foreach ($productProperties as $key => $property) {
                                $where = !$key ? 'where' : 'orWhere';

                                $query->{$where}(function (Builder $query) use ($property) {
                                    $query->where('pp.property_id', $property->property_id);

                                    $fieldValueIds = json_decode($property->field_value_ids, false, 512, JSON_THROW_ON_ERROR);

                                    if (is_array($fieldValueIds)) {
                                        foreach ($fieldValueIds as $fieldValueId) {
                                            $query->whereRaw("JSON_CONTAINS(JSON_EXTRACT(pp.field_value_ids, '$[*]'), '$fieldValueId', '$')");
                                        }
                                    } else {
                                        $query->where('pp.field_value_ids', $fieldValueIds);
                                    }
                                });
                            }
                        })
                        ->groupBy('analog_id')
                        ->orderByDesc('total')
                        ->limit(self::COUNT_ANALOGS)
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

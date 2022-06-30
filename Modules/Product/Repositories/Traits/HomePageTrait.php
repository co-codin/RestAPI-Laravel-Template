<?php

namespace Modules\Product\Repositories\Traits;

use App\Enums\Status;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;

trait HomePageTrait
{
    public function getProductsHot()
    {
        return Product::query()
            ->select([
                'products.id',
                'products.name',
                'products.article',
                'products.image',
                'products.slug',
                'products.group_id',
            ])
            ->where([
                ['is_in_home', '=', true],
                ['status', '=', Status::ACTIVE],
                ['group_id', '=', ProductGroup::IMPOSSIBLE]
            ])
            ->with(['brand', 'stockType', 'category', 'images', 'productReviews', 'productAnswers'])
            ->addSelect(['main_variation_id' => ProductVariation::select('product_variations.id')
                ->whereColumn('product_id', 'products.id')
                ->where('is_enabled', true)
                ->leftJoin('currencies', 'currency_id', 'currencies.id')
                ->orderByRaw('rate * price ASC')
                ->take(1),
            ])
            ->with('mainVariation')
            ->whereExists(function (QueryBuilder $builder) {
                $builder
                    ->select(DB::raw(1))
                    ->from('product_variations as pv')
                    ->whereRaw('pv.product_id = products.id')
                    ->whereNotNull('pv.previous_price')
                    ->whereNotNull('pv.price')
                    ->where('pv.is_price_visible', true);
            })
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('product_property as pp')
                    ->whereColumn('pp.product_id', 'products.id')
                    ->where('pp.property_id', static::COVID_PROPERTY_ID)
                    ->whereJsonContains('pp.field_value_ids', 1);
            })
            ->get();
    }
}

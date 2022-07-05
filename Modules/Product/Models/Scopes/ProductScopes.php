<?php

namespace Modules\Product\Models\Scopes;

use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductVariation;

trait ProductScopes
{
    public function scopeWithPrice(Builder $query)
    {
        $query->addSelect(['price' => ProductVariation::selectRaw('rate * price')
            ->whereColumn('product_id', 'products.id')
            ->join('currencies', 'currency_id', 'currencies.id')
            ->orderByRaw('rate * price ASC')
            ->take(1),
        ]);
    }

    public function scopeWithMainVariation(Builder $query)
    {
        $query->addSelect(['main_variation_id' => ProductVariation::select('product_variations.id')
            ->whereColumn('product_id', 'products.id')
            ->where('is_enabled', true)
            ->leftJoin('currencies', 'currency_id', 'currencies.id')
            ->orderByRaw('rate * price ASC')
            ->with('currency')
            ->take(1),
        ])
            ->with([
                'mainVariation', 'mainVariation.currency'
            ]);
    }

    public function scopeHot(Builder $query, bool $hot)
    {
        $query->whereExists(function (QueryBuilder $builder) use ($hot) {
            $builder
                ->select(DB::raw(1))
                ->from('product_variations as pv')
                ->whereRaw('pv.product_id = products.id');

            if ($hot) {
                $builder
                    ->whereNotNull('pv.previous_price')
                    ->whereNotNull('pv.price')
                    ->where('pv.is_price_visible', true);
            } else {
                $builder
                    ->where('pv.is_price_visible', false)
                    ->orWhereNull('pv.previous_price');
            }
        });
    }

    public function scopeFromCovid(Builder $query, bool $fromCovid)
    {
        $method = $fromCovid ? "whereExists" : "whereNotExists";

        $query->{$method}(function ($query) {
            $query->select(DB::raw(1))
                ->from('product_property as pp')
                ->whereColumn('pp.product_id', 'products.id')
                ->where('pp.property_id', static::COVID_PROPERTY_ID)
                ->whereJsonContains('pp.field_value_ids', 1);
        });
    }

    public function scopeHasActiveVariation(Builder $query)
    {
        return $query->havingRaw('main_variation_id is not null');
    }

    public function stockType()
    {
        return $this->belongsTo(FieldValue::class);
    }
}

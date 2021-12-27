<?php


namespace Modules\Product\Services;


use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;
use Modules\Product\Enums\ProductGroup;

class ProductBuilders
{
    const COVID_PROPERTY_ID = 259;

    public function rootCategory(Builder $builder, int $rootCategory): Builder
    {
        $rootCategory = Category::findOrFail($rootCategory);

        $ids = $rootCategory->descendants()
            ->pluck('id')
            ->add($rootCategory->id);

        return $builder->whereHas(
            'productCategories',
            fn($builder) => $builder->whereIn('category_id', $ids)
        );
    }

    public function fromCovid(Builder $builder, bool $fromCovid): Builder
    {
        $method = $fromCovid ? "whereExists" : "whereNotExists";

        return $builder->{$method}(function ($query) {
            $query->select(DB::raw(1))
                ->from('product_property as pp')
                ->whereColumn('pp.product_id', 'products.id')
                ->where('pp.property_id', static::COVID_PROPERTY_ID)
                ->whereJsonContains('pp.field_value_ids', 1);
        });
    }

    public function onlyActiveAnalogs(Builder $builder, bool $active): Builder
    {
        $method = $active ? "whereExists" : "whereNotExists";

        return $builder->{$method}(function (QueryBuilder $query) {
            $query
                ->select(DB::raw(1))
                ->from('product_analog as pa')
                ->whereColumn('products.id', 'pa.analog_id')
                ->where('products.status', Status::ACTIVE)
                ->where(function (QueryBuilder $query) {
                    $query
                        ->where('products.group_id', ProductGroup::PRIORITY)
                        ->orWhere('products.group_id', ProductGroup::REORIENTATED);
                });
        });
    }

    public function getProductsByCategories(Builder $builder, array $categoryIds): Builder
    {
        return $builder->whereExists(function (QueryBuilder $builder) use ($categoryIds) {
            $builder
                ->select(DB::raw(1))
                ->from('product_category as pc')
                ->whereRaw('pc.product_id = products.id')
                ->whereIn('pc.category_id', $categoryIds);
        });
    }

    public function getHotProducts(Builder $builder, bool $hot): Builder
    {
        return $builder->whereExists(function (QueryBuilder $builder) use ($hot) {
            $builder
                ->select(DB::raw(1))
                ->from('product_variations as pv')
                ->whereRaw('pv.product_id = products.id');

            if ($hot) {
                $builder
                    ->whereNotNull('pv.previous_price')
                    ->where('pv.is_price_visible', true);
            } else {
                $builder
                    ->where('pv.is_price_visible', false)
                    ->orWhereNull('pv.previous_price');
            }
        });
    }
}

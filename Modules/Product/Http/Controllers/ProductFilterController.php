<?php

namespace Modules\Product\Http\Controllers;


use App\Enums\Status;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Modules\Filter\Collections\FilterCollection;
use Modules\Filter\Models\Filter;
use Modules\Product\Enums\ProductVariationStock;
use Modules\Product\Http\Requests\ProductFilterRequest;
use Modules\Product\Http\Resources\FilteredProductResourceCollection;
use Modules\Product\Services\ProductFilter;
use Modules\Search\Filters\ExistsFilter;
use Modules\Search\Filters\NestedFilter;
use Modules\Search\Filters\TermFilter;
use Modules\Search\Filters\TermsFilter;

class ProductFilterController extends Controller
{
    public function __construct(
        protected ProductFilterRequest $request,
        protected ProductFilter $productFilter
    )
    {
    }

    public function index(): FilteredProductResourceCollection
    {
        $defaultFilters = $this->getDefaultFilters();
        $filters = $this->getFilters();

        dd($filters->toArray());

        $products = $this->productFilter
            ->setDefaultFilters($defaultFilters)
            ->setFilters(new FilterCollection)
            ->setPage($this->request->input('page.number') ?? 1)
            ->setSize($this->request->input('page.size') ?? 15)
            ->setSort($this->request->input('orderBy') ?? 'popular')
            ->getItems();

        return new FilteredProductResourceCollection($products);
    }

    protected function getDefaultFilters(): FilterCollection
    {
        return new FilterCollection(
            collect($this->request->input('defaultFilters') ?? [])
                ->map(function ($filter) {
                    return $this->availableFilters()[$filter['key']]($filter['value']);
                })
        );
    }

    protected function getFilters(): FilterCollection|Collection
    {
        $filters = $this->request->input('filters');

        return Filter::query()
            ->find(\Arr::pluck($filters, 'key'))
            ->loadValues(\Arr::pluck($filters, 'value', 'key'));
    }

    protected function availableFilters(): array
    {
        return [
            'is_active' => function () {
                return new TermFilter('status.id', Status::ACTIVE);
            },
            'has_active_variation' => function () {
                return new NestedFilter('variations', [
                    new TermFilter('variations.is_enabled', true),
                ]);
            },
            'category.id' => function ($value) {
                return new TermFilter('category.id', $value);
            },
            'categories.id' => function ($value) {
                return new NestedFilter('categories', [
                    new TermsFilter('categories.id', $value),
                ]);
            },
            'is_hot' => function () {
                return new NestedFilter('variations', [
                    new ExistsFilter('variations.previous_price'),
                ]);
            },
            'is_price_visible' => function () {
                return new NestedFilter('variations', [
                    new TermFilter('variations.is_price_visible', true),
                ]);
            },
            'is_available' => function () {
                return new NestedFilter('variations', [
                    new TermsFilter('variations.availability', [
                        ProductVariationStock::InStock,
                        ProductVariationStock::UnderTheOrder,
                        ProductVariationStock::ComingSoon
                    ]),
                ]);
            },
            'brand.country' => function ($value) {
                return new TermFilter('brand.country', $value);
            },
        ];
    }
}

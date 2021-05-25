<?php


namespace Modules\Filter\Collections;


use App\Services\Filters\ProductFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Filter\Models\Filter;

class FilterCollection extends Collection
{
    const MERGING_PATHS = ['variations'];

    public function isEnabled() : bool
    {
        return $this->enabled()->isNotEmpty();
    }

    public function enabled()
    {
        return $this->filter->is_enabled;
    }

    public function getTags()
    {
        return $this->enabled()
            ->values()
            ->map(function(Filter $filter) {
                return $filter->only('name', 'slug');
            })
            ->toArray();
    }

    public function getQuery()
    {
        return $this->map->toFilter()
            ->groupBy('nested.path')
            ->map(function(Collection $group, string $path) {
                if(in_array($path, static::MERGING_PATHS) && $group->count() > 1) {
                    $group = [Arr::mergeRecursive(...$group->toArray())];
                }
                return $group;
            })
            ->collapse()
            ->toArray();
    }

    public function getAggregations() : array
    {
        return $this->values()->map->toAggregation()
            ->groupBy("*.nested.path")
            ->map(function(Collection $group, string $path) {
                if($path && $group->count() > 1) {
                    $group = [Arr::mergeRecursive(...$group->toArray())];
                }
                return $group;
            })
            ->flatten(1)
            ->collapse()
            ->toArray();
    }

    public function loadValues(array $values)
    {
        return $this->each(function($filter) use ($values) {
            $filter->value = Arr::get($values, $filter->slug);
        });
    }

    public function loadAggregations()
    {
        app(ProductFilter::class)
            ->setFilters($this)
            ->getProducts();
    }

    public function fillAggregations(? array $aggregations)
    {
        $un_dotted = [];

        foreach (Arr::dot($aggregations) as $key => $value) {
            Arr::set($un_dotted, $key, $value);
        }

        return $this->each(function(Filter $item) use ($un_dotted) {
            $item->fillAggregation(
                Arr::get($un_dotted, $item->getAggregationPath())
            );
        });
    }
}

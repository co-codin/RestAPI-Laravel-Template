<?php


namespace Modules\Filter\Collections;


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
}

<?php


namespace Modules\Filter\Services;


use Modules\Filter\Dto\FilterDto;
use Modules\Filter\Models\Filter;

class FilterStorage
{
    public function store(FilterDto $filterDto)
    {
        $filter = new Filter($filterDto->toArray());

        if (!$filter->save()) {
            throw new \LogicException('can not create filter.');
        }

        return $filter;
    }

    public function update(Filter $filter, FilterDto $filterDto)
    {
        if (!$filter->update($filterDto->toArray())) {
            throw new \LogicException('can not update filter.');
        }

        return $filter;
    }

    public function delete(Filter $filter)
    {
        if (!$filter->delete()) {
            throw new \LogicException('can not delete filter.');
        }
    }

    public function sort(array $filters)
    {
        foreach ($filters as $filter) {
            Filter::query()
                ->where('id', $filter['id'])
                ->update(['position' => $filter['position']]);
        }
    }
}

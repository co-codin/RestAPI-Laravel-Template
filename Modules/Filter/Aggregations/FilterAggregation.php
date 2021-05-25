<?php


namespace Modules\Filter\Aggregations;

use Illuminate\Support\Arr;
use Modules\Search\Contracts\Aggregation;

class FilterAggregation implements Aggregation
{
    protected $name;
    protected $filter;
    protected $aggregations;

    public function __construct(string $name, array $filter, array $aggregations)
    {
        $this->name = $name;
        $this->filter = $filter;
        $this->aggregations = $aggregations;
    }

    public function toAggregation() : array
    {
        $aggregations = array_map(function(Aggregation $aggregation) {
            return Arr::collapse($aggregation->toAggregation());
        }, $this->aggregations);

        return [
            $this->name => [
                'filter' => $this->filter,
                'aggs' => [
                    'filtered' => Arr::collapse($aggregations),
                ],
            ],
        ];
    }
}

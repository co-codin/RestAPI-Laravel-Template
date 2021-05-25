<?php


namespace Modules\Filter\Aggregations;

use Illuminate\Support\Arr;
use Modules\Filter\Contracts\AggregationInterface;

class FilterAggregation implements AggregationInterface
{
    public function __construct(
        protected string $name,
        protected array $filter,
        protected array $aggregations
    ) {}

    public function toAggregation() : array
    {
        $aggregations = array_map(function(AggregationInterface $aggregation) {
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

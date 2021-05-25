<?php

namespace Modules\Filter\Aggregations;

use Illuminate\Support\Arr;
use Modules\Filter\Contracts\AggregationInterface;

class NestedAggregation implements AggregationInterface
{
    public function __construct(
        protected string $path,
        protected array $aggregations,
        protected ?string $name = null
    ){}

    public function toAggregation() : array
    {
        $aggregations = array_map(function(AggregationInterface $aggregation) {
            return $aggregation->toAggregation();
        }, $this->aggregations);

        return [
            $this->name => [
                'nested' => [
                    'path' => $this->path,
                ],
                'aggs' => Arr::collapse($aggregations),
            ],
        ];
    }
}

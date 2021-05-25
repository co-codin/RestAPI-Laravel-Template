<?php

namespace Modules\Filter\Aggregations;

use Illuminate\Support\Arr;
use Modules\Search\Contracts\Aggregation;

class NestedAggregation implements Aggregation
{
    protected $name;
    protected $aggregations;
    protected $path;

    public function __construct(string $path, array $aggregations, ?string $name = null)
    {
        $this->path = $path;
        $this->aggregations = $aggregations;
        $this->name = $name ?? $path;
    }

    public function toAggregation() : array
    {
        $aggregations = array_map(function(Aggregation $aggregation) {
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

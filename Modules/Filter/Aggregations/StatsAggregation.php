<?php


namespace Modules\Filter\Aggregations;


use Modules\Filter\Contracts\AggregationInterface;

class StatsAggregation implements AggregationInterface
{
    public function __construct(
        protected string $name,
        protected string $field
    )
    {}

    public function toAggregation() : array
    {
        return [
            $this->name => [
                'stats' => [
                    "field" => $this->field,
                ],
            ],
        ];
    }
}

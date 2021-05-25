<?php


namespace Modules\Filter\Aggregations;


use Modules\Filter\Contracts\AggregationInterface;

class BucketsAggregation implements AggregationInterface
{
    public function __construct(
        protected string $name,
        protected string $field,
        protected string $field_name = "field"
    ) {}

    public function toAggregation(): array
    {
        return [
            $this->name => [
                'terms' => [
                    $this->field_name => $this->field,
                    'size' => 100,
                ],
            ],
        ];
    }

}

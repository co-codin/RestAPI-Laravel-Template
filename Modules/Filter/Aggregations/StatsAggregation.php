<?php


namespace Modules\Filter\Aggregations;


use Modules\Search\Contracts\Aggregation;

class StatsAggregation implements Aggregation
{
    protected $name;
    protected $field;

    public function __construct(string $name, string $field)
    {
        $this->name = $name;
        $this->field = $field;
    }

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

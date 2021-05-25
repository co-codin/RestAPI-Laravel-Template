<?php


namespace Modules\Filter\Aggregations;

use Modules\Search\Contracts\Aggregation;

class BucketsAggregation implements Aggregation
{
    protected $name;
    protected $field;
    protected $field_name;

    public function __construct(string $name, string $field, string $field_name = "field")
    {
        $this->name = $name;
        $this->field = $field;
        $this->field_name = $field_name;
    }

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

<?php


namespace Modules\Filter\Filters;



use Modules\Filter\Contracts\FilterInterface;

class RangeFilter implements FilterInterface
{
    public function __construct(
        protected string $field,
        protected $value
    ) {}

    public function toFilter(): array
    {
        return [
            "range" => [
                $this->field => $this->value,
            ]
        ];
    }
}

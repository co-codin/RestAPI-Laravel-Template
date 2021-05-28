<?php


namespace Modules\Filter\Filters;


use Modules\Filter\Contracts\FilterInterface;

class TermFilter implements FilterInterface
{
    public function __construct(
        protected string $field,
        protected $value
    ) {}

    public function toFilter(): array
    {
        return [
            'term' => [
                $this->field => $this->value,
            ],
        ];
    }
}

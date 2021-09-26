<?php


namespace Modules\Search\Filters;


use Modules\Search\Contracts\Filter;

class ExistsFilter implements Filter
{
    public function __construct(
        protected string $field,
    ) {}

    public function toFilter(): array
    {
        return [
            'exists' => [
                'field' => $this->field,
            ],
        ];
    }
}

<?php


namespace Modules\Filter\Filters;

use Modules\Filter\Contracts\FilterInterface;

class TermsFilter implements FilterInterface
{
    public function __construct(
        protected string $field,
        protected $value
    ) {}

    public function toFilter(): array
    {
        return [
            'terms' => [
                $this->field => $this->value,
            ],
        ];
    }
}

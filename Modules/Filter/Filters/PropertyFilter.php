<?php


namespace Modules\Filter\Filters;


use Modules\Filter\Contracts\FilterInterface;

class PropertyFilter implements FilterInterface
{
    public function __construct(
        protected  string $path,
        protected FilterInterface $filter,
        protected array $propertyFilter
    ) {}

    public function toFilter() : array
    {
        return [$this->filter->toFilter(), $this->propertyFilter];
    }
}

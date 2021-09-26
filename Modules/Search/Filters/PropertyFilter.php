<?php


namespace Modules\Search\Filters;

use Modules\Search\Contracts\Filter;

class PropertyFilter implements Filter
{
    protected $path;
    protected $filter;
    protected $propertyFilter;

    public function __construct(string $path, Filter $filter, array $propertyFilter)
    {
        $this->path = $path;
        $this->filter = $filter;
        $this->propertyFilter = $propertyFilter;
    }

    public function toFilter() : array
    {
        return [$this->filter->toFilter(), $this->propertyFilter];
    }
}

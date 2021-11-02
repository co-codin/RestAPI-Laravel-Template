<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class IsEmptyFilter implements Filter
{
    public function __construct(
        protected string $column
    ) {}

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereNull($this->column);
    }
}

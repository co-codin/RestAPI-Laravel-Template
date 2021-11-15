<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class IsEmptyFilter implements Filter
{
    public function __construct(
        protected string $column,
    ) {}

    public function __invoke(Builder $query, $value, string $property)
    {
        if($value) {
            $query->whereNotNull($this->column);
        }
        else {
            $query->whereNull($this->column);
        }
    }
}

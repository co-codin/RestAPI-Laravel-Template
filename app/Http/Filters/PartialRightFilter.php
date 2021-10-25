<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class PartialRightFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where($property, 'like', $value . "%");
    }
}

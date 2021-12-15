<?php


namespace App\Http\Sorts;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class NullsLast implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->orderByRaw("-{$property} DESC");
    }
}

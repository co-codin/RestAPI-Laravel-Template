<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class EmptyColumnFilter implements Filter
{
    /**
     * @param Builder $query
     * @param bool $empty
     * @param string $property
     * @throws \Exception
     */
    public function __invoke(Builder $query, $empty, string $property)
    {
        if (!is_bool($empty)) {
            throw new \Exception('An empty filter must receive a boolean value ');
        }

        if ($empty) {
            $query
                ->where($property, '=', '')
                ->orWhereNull($property);
        } else {
            $query
                ->where($property, '!=', '')
                ->whereNotNull($property);
        }
    }
}

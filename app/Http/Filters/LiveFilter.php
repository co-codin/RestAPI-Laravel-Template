<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class LiveFilter implements Filter
{
    public function __construct(
        protected array $columns
    ) {}

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($query) use ($value) {
            if ($words = explode(' ', $value)) {
                foreach (\Arr::wrap($this->columns) as $column => $operator) {
                    if ($column === 'name') {
                        foreach ($words as $word) {
                            $query->where($column, $operator, $operator === "like" ? "%$word%": $word);
                        }
                    } else {
                        $query->orWhere($column, $operator, $operator === "like" ? "%$value%": $value);
                    }
                }
            }
        });
    }
}

<?php


namespace App\Http\Filters;


use App\Dto\HttpBuilderRelationDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class HasRelationTableFilter implements Filter
{
    private HttpBuilderRelationDto $relationDto;

    public function __construct(HttpBuilderRelationDto $relationDto)
    {
        $this->relationDto = $relationDto;
    }

    /**
     * @param Builder $query
     * @param string|int $hasTable
     * @param string $property
     * @throws \Exception
     */
    public function __invoke(Builder $query, $hasTable, string $property)
    {
        $relationDto = $this->relationDto;

        $fn = function (QueryBuilder $query) use ($relationDto) {
            $query->select(\DB::raw(1))
                ->from($relationDto->table)
                ->whereRaw("{$relationDto->first} = {$relationDto->second}");
        };

        if ($hasTable) {
            $query->whereExists($fn);
        } else {
            $query->whereNotExists($fn);
        }
    }
}

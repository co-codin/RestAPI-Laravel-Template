<?php


namespace Modules\Search\Filters;


use Illuminate\Support\Arr;
use Modules\Search\Contracts\Filter;

class NestedFilter implements Filter
{
    protected $path;
    protected $filters;

    public function __construct(string $path, array $filters)
    {
        $this->path = $path;
        $this->filters = $filters;
    }

    public function toFilter(): array
    {
        $filters = Arr::wrap(array_map(function(Filter $filter) {
            return $filter->toFilter();
        }, $this->filters));

        if(isset($filters[0][0])) {
            $filters = Arr::collapse($filters);
        }

        return [
            'nested' => [
                'path' => $this->path,
                'query' => [
                    'bool' => [
                        'must' => $filters,
                    ],
                ]
            ]
        ];
    }
}

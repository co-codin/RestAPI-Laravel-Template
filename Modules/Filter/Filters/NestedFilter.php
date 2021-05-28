<?php


namespace Modules\Filter\Filters;


use Illuminate\Support\Arr;
use Modules\Filter\Contracts\FilterInterface;

class NestedFilter implements FilterInterface
{
    public function __construct(
        protected string $path,
        protected array $filters
    ){}

    public function toFilter(): array
    {
        $filters = Arr::wrap(array_map(function(FilterInterface $filter) {
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

<?php


namespace App\Dto;


class HttpBuilderRelationDtoCollection extends BaseDtoCollection
{
    public function __construct($items = [])
    {
        $items = array_map(
            fn (HttpBuilderRelationDto|array $data): HttpBuilderRelationDto => $data instanceof HttpBuilderRelationDto
                ? $data
                : new HttpBuilderRelationDto(...$data),
            $items
        );

        parent::__construct($items);
    }

    public function offsetGet($key): HttpBuilderRelationDto
    {
        return parent::offsetGet($key);
    }
}
